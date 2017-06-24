<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;
use AlterFalter\Service\Login\LoginService;
use AlterFalter\Controller\MailController;
use AlterFalter\Controller\IndexController;
use AlterFalter\Controller\SystemController;
use AlterFalter\Models\User;

class LoginController 
{
  /**
   * @var AlterFalter\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $loginService;
  private $mailController;
  private $indexController;
  private $systemController;
  private $errorController;
  
  /**
   * @param AlterFalter\SimpleTemplateEngine
   */
  public function __construct(
    SimpleTemplateEngine $template, 
    LoginService $loginService, 
    MailController $mailController, 
    IndexController $indexController, 
    SystemController $systemController, 
    ErrorController $errorController)
  {
     $this->template = $template;
     $this->loginService = $loginService;
     $this->mailController = $mailController;
     $this->indexController = $indexController;
     $this->systemController = $systemController;
     $this->errorController = $errorController;
  }

  public function userIsLoggedIn()
  {
    //var_dump($_SESSION); die();
    return (isset($_SESSION) && isset($_SESSION["IsLoggedIn"]) && $_SESSION["IsLoggedIn"]);
  }

  public function loginGET(){
    if ($this->userIsLoggedIn())
    {
      return $this->indexController->home();
    }

    echo $this->template->renderView("login.html.php", [
      "token" => $this->systemController->getHtmlToken()
    ]);
  }
  
  public function loginPOST(array $data)
  {
  	if ($this->userIsLoggedIn() || !$this->systemController->checkCSRFToken($data))
  	{
  		return $this->indexController->home();
  	}
  	if (!array_key_exists("email", $data) || !array_key_exists("password", $data))
  	{
      return $this->loginGET();
  	}
    $email = $data["email"];
    $password = $data["password"];
  	
  	if ($this->loginService->authenticate($email, $password))
  	{
      $this->login($email);
      $this->indexController->home();
  	}
  	else 
  	{
  		echo $this->template->renderView("login.html.php", [
        "errorMessage" => "Email or password is false",
  			"email" => $data["email"],
        "token" => $this->systemController->getHtmlToken()
  		]);
  	}
  }

  private function login($email)
  {
    session_regenerate_id(true); // prevents session hijacking
    // set session
    $_SESSION["IsLoggedIn"] = TRUE;
    $_SESSION["userId"] = $this->loginService->getUserId($email);
    $_SESSION["email"] = $email;
  }

  /*
   * Email validiert
   */
  public function confirm($data)
  {
    if (array_key_exists("guid", $data) && $this->loginService->emailVerification($data["guid"]))
    {
      echo $this->template->renderView("confirmemail.html.php");
    }
    else
    {
      return $this->indexController->home();
    }

  }

  public function registerGET()
  {
    if ($this->userIsLoggedIn())
    {
      return $this->indexController->home();
    }
    else
    {
      echo $this->template->renderView("register.html.php", [
        "token" => $this->systemController->getHtmlToken()
      ]);
    }
  }
  
  public function registerPOST(array $data)
  {
    if ($this->userIsLoggedIn() || !$this->systemController->checkCSRFToken($data))
    {
      return $this->indexController->home();
    }
    $email = $data["email"];
    $firstname = $data["firstname"];
    $surname = $data["surname"];
    $password = $data["password"];
    $password2 = $data["password2"];

    $errorMessage = "";

    // is email set
    if (!isset($email))
    {
      $errorMessage .= "No e-mail specified!<br/>";
    }
    // has email the right format
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $errorMessage .= "E-mail doesn't have the right format!<br/>";
    }
    // if email is too longpassword
    else if (!(strlen($email) < 50))
    {
      $errorMessage .= "E-mail is too long!<br/>";
    }
    // is email already registered
    else if ($this->loginService->DoesEmailAlreadyExist($email))
    {
      $errorMessage .= "E-mail is already registered!<br/>";
    }

    // is firstname set
    if (!isset($firstname))
    {
      $errorMessage .= "No firstname specified!<br/>";
    }
    // has only letters
    else if (!(ctype_alpha($firstname)))
    {
      $errorMessage .= "Firstname can't have other characters than A-Z! Please notice that you can't use ä,ö,ü etc.<br/>";
    }
    // if it's too long
    else if (!(strlen($firstname) < 20))
    {
      $errorMessage .= "Firstname is too long! The maximum length is 20 characters!<br/>";
    }

    // is surname set
    if (!isset($surname))
    {
      $errorMessage .= "No surname specified!<br/>";
    }
    // has only letters
    else if (!(ctype_alpha($surname)))
    {
      $errorMessage .= "Surname can't have other characters than A-Z! Please notice that you can't use ä,ö,ü etc.<br/>";
    }
    // is surname too long
    else if (!(strlen($surname) < 20))
    {
      $errorMessage .= "Surname is too long! The maximum length is 20 characters!<br/>";
    }

    // is password set
    if (!isset($password) || !isset($password2))
    {
      $errorMessage .= "No password specified!<br/>";
    }
    // are both passwords the same
    else if ($password != $passwopasswordrd2)
    {
      $errorMessage .= "Passwords are not the same!<br/>";
    }
    // check length
    else if (!(strlen($password) < 32))
    {
      $errorMessage .= "Password is too long! The maximum length is 32 characters!<br/>";
    }

    if ($errorMessage == "")
    {
      $user = new User(0, 0, $firstname, $surname, $email, $password);
      $guid = $this->systemController->createGUID();
      $userId = $this->loginService->registerUser(
        $user,
        $guid
      );

      if ($userId > 0)
      {
        // send mail with guid for verification
        $this->mailController->sendMail(
          $email,
          "E-mail verification - ZeusDrive",
          "Hello " . $firstname . " " . $surname . 
          '<br/><br/>Please click on this <a href="https://localhost/confirm?id=' . $userId . '&guid=' . $guid . '">Link</a> to verify your email adress.' . 
          "<br/><br/>Kind regards" .
          "<br/>ZeusDrive-Team",
          'text/html'
        );
        $this->login($email);
	      echo $this->template->renderView("confirmregistration.html.php");
        return;
      }
      else
      {
        $errorMessage .= "Something went wrong with the database.";
      }
    }
    echo $this->template->renderView("register.html.php", [
      "token" => $this->systemController->getHtmlToken(),
      "errorMessage" => $errorMessage,
      "email" => $email,
      "firstname" => $firstname,
      "surname" => $surname
    ]);
  }

  public function logout()
  {
    // https://www.w3schools.com/php/php_sessions.asp
    session_unset();
    session_destroy();
    return $this->indexController->home();
  }

  public function forgotPasswordGET()
  {
    if ($this->userIsLoggedIn())
    {
      return $this->indexController->home();
    }
    echo $this->template->renderView("forgotpassword.html.php", [
      "token" => $this->systemController->getHtmlToken()
    ]);
  }

  public function forgotPasswordPOST($data)
  {
    if ($this->userIsLoggedIn() || !$this->systemController->checkCSRFToken($data))
    {
      return $this->indexController->home();
    }

    $errorMessage = "";

    if (!isset($data) || !array_key_exists("email", $data))
    {
      $errorMessage .= "E-mail is not specified!<br/>";
      echo $this->template->renderView("forgotpassword.html.php");
      return;
    }

    $email = $data["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $errorMessage .= "E-mail doesn't have the right format!<br/>";
      echo $this->template->renderView("forgotpassword.html.php", [
        "token" => $this->systemController->getHtmlToken(),
        "errorMessage" => $errorMessage,
        "email" => $data["email"]
      ]);
      return;
    }

    $guid = $this->systemController->createGUID();
    $userId = $this->loginService->getUserId($email);
    $this->loginService->savePasswordGuid($userId, $guid);

    $this->mailController->sendMail(
      $email,
      "Forgot your password",
      'Hello<br/><br/>Click <a href="https://localhost/setpassword?userId=' . $userId . "&guid=" . $guid . '">here</a> to enter a new password.<br/><br/>Your ZeusDrive-Team');
    echo $this->template->renderView("confirmpassword.html.php");
  }

  public function setNewPasswordGET($data)
  {
    // if guid is specified
    if (!isset($data) || !isset($data["userId"]) || !isset($data["guid"]) || $this->userIsLoggedIn())
    {
      return $this->loginGET();
    }
    else
    {
      $guid = $data["guid"];
      $userId = $data["userId"];
    }
    // if guid exists
    if ($this->loginService->passwordGuidExists($userId, $guid))
    {
      echo $this->template->renderView("setpassword.html.php", [
        "token" => $this->systemController->getHtmlToken(),
        "userId" => $userId,
        "guid" => $guid
      ]);
    }
    else
    {
      return $this->errorController->error(403, "Stop trying to hack our site!");
    }
  }

  public function setNewPasswordPOST($data)
  {
    //var_dump($data); die;
    if (!isset($data["password"]) ||
        !isset($data["password2"]) ||
        !isset($data["userId"]) ||
        !isset($data["guid"]) ||
        $this->userIsLoggedIn() ||
        !$this->systemController->checkCSRFToken($data))
    {
      return $this->indexController->home();
    }

    $password = $data["password"];
    $password2 = $data["password2"];
    $userId = $data["userId"];
    $guid = $data["guid"];
    $errorMessage = "";

    // are both passwords the same
    if ($password != $password2)
    {
      $errorMessage .= "Passwords are not the same!<br/>";
    }
    // check length
    else if (strlen($password) > 32)
    {
      $errorMessage .= "Password is too long! The maximum length is 32 characters!<br/>";
    }

    if ($errorMessage == "" && $this->loginService->passwordGuidExists($userId, $guid))
    {
      $this->loginService->setNewPassword($userId, $guid, $password);
      echo $this->template->renderView("confirmpasswordset.html.php");
    }
    else
    {
      echo $this->template->renderView(
        "setpassword.html.php", [
        "token" => $this->systemController->getHtmlToken(),
        "userId" => $userId,
        "guid" => $guid,
        "errorMessage" => $errorMessage
      ]);
    }
  }

  function sessionExists() {
   return ($_SESSION['is_open']);
  }
}
