<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;
use AlterFalter\Service\Drive\DriveService;
use AlterFalter\Controller\ErrorController;
use AlterFalter\Controller\LoginController;
use AlterFalter\Controller\SystemController;
use AlterFalter\ErrorType;

class DriveController 
{
  /**
   * @var AlterFalter\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $driveService;
  private $errorController;
  private $loginController;
  private $systemController;
  
  /**
   * @param AlterFalter\SimpleTemplateEngine
   */
  public function __construct(
    SimpleTemplateEngine $template,
    DriveService $driveService,
    ErrorController $errorController,
    LoginController $loginController,
    SystemController $systemController)
  {
    $this->template = $template;
    $this->driveService = $driveService;
    $this->errorController = $errorController;
    $this->loginController = $loginController;
    $this->systemController = $systemController;
  }

  public function folder(array $data)
  {
    // is user logged in
    if ($this->loginController->userIsLoggedIn())
    {
      if (isset($data["folderId"]))
      {
        $folderId = $data["folderId"];
        if ($folderId == 0 || $folderId < -1)
        {
          $folderId = 0;
        }
      }
      else 
      {
        $folderId = 0;
      }
      if ($this->driveService->userHasAccessToFolder($folderId, $_SESSION["userId"]))
      {
        $folder = $this->driveService->folder($folderId);
        echo $this->template->renderEditView("folder.html.php", [
          "token" => $this->systemController->getHtmlToken(),
          "folder" => $folder
        ]);
        return;
      }
      else
      {
        return $this->errorController->error(
          403,
          "You are not allowed to access this folder"
        );
      }
    }
    return $this->errorController->error(
      401,
      "You can't acces this site when you're not logged in"
    );
  }

  public function download($data)
  {
    if ($this->loginController->userIsLoggedIn() &&
        isset($data) &&
        isset($data["fileId"]) &&
        $this->driveService->userHasAccessToFile($fileId))
    {
      $fileId = $data["fileId"];
      $file = $this->driveService->getFile($fileId);
      echo $this->template->renderView("downloadfile.html.php", [
        "file" => $this->driveService->getfile($fileId)
      ]);
      return;
    }
    echo $this->errorController->error(
      403,
      "You don't have the permission to download this file or it doesn't exist!"
    );
  }

  public function uploadFile($data)
  {
    if ($this->loginController->userIsLoggedIn())
    {
      return $this->loginController->loginGET();
    }
    $folderId = 0;
    if (isset($data["folderId"]))
    {
      $folderId = $data["folderId"];
    }
    
    if ($this->driveService->userHasAccessToFolder($folderId) && 
        isset($data["data"]) &&
        isset($data["filename"]) &&
        isset($data["folderId"]))
    {
      $filename = $data["filename"];
      $extension = end(split('.',$filename));
      $filename = substr($filename,0,strrpos($filename,'.'));
      $filedata = $data["data"];
      $folderId = $data["folderId"];

      $this->driveService->uploadFile($filedata, $filename, $extension, $folderId);
    }
    return $this->folder($folderId);
  }

  public function deleteFile($data)
  {
    if (isset($data["fileId"]) && $this->loginController->userIsLoggedIn())
    {
      $fileId = $data["fileId"];
      if ($this->driveService->userHasAccessToFile($fileId))
      {
        $this->driveService->deleteFile($fileId);
      }
    }
    return $this->folder(0);
  }

  public function createFolder($data)
  {
    if (isset($data["folderName"]) && isset($data["parentFolderId"]) && $this->loginController->userIsLoggedIn())
    {
      $folderName = $data["folderName"];
      $parentFolderId = $data["parentFolderId"];
      if ($this->driveService->userHasAccessToFolder())
      {
        $folderId = $this->driveService->createFolder($folderName, $parentFolderId);
        return $this->folder($folderId);
      }
    }
    return $this->loginController->loginGET();
  }

  public function deleteFolder($data)
  {
    if (isset($data["folderId"]) && $this->loginController->userIsLoggedIn())
    {
      $folderId = $data["folderId"];
      if ($this->driveService->userHasAccessToFolder($folderId))
      {
        $this->driveService->deleteFolder($folderId);
      }
    }
    return $this->folder(0);
  }
}