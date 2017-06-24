<?php 

namespace AlterFalter\Service\Drive;

use AlterFalter\Service\Drive\DriveService;
use AlterFalter\Models\Folder;
use AlterFalter\Models\File;

class DrivePdoService implements DriveService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getMainFolderId()
	{
		$statement = $this->pdo->prepare("SELECT MainFolderId FROM user WHERE email=?");
		$statement->bindValue(1, $_SESSION["email"]);
		$statement->execute();
		return $statement->fetch()["MainFolderId"];
	}

	public function getSharedFolder()
	{
		$statement = $this->pdo->prepare("SELECT * FROM folder WHERE Id=''");
		$statement->bindValue(1, "");
		$statement->execute();

		return $folder;
	}
	
	public function folder($folderId)
	{
		if (is_numeric($folderId))
		{
			$isMainFolder = false;
			if ($folderId == 0 || $folderId < -1)
			{
				$isMainFolder = true;
				$folderId = $this->getMainFolderId();
			}
			else if ($folderId == -1)
			{
				return $this->getSharedFolder();
			}

			// get folder
			$statement = $this->pdo->prepare("SELECT * FROM folder WHERE Id=?");
			$statement->bindValue(1, $folderId);
			$statement->execute();

			$folder = new Folder(
				$folderId,
				$statement->fetch()["ParentFolderId"],
				$statement->fetch()["Name"], 
				NULL,
				NULL,
				$isMainFolder);

			// get childfolders
			$statement = $this->pdo->prepare("SELECT * FROM folder WHERE ParentFolderId=?");
			$statement->bindValue(1, $folderId);
			$statement->execute();
			foreach ($statement->fetchAll() as $DBchildFolder)
			{
				$childFolder = new Folder($DBchildFolder["Id"], $folderId, $DBchildFolder["Name"], NULL, NULL);///////////
				$folder->folders[] = $childFolder;
			}

			// get files
			$statement = $this->pdo->prepare("SELECT * FROM file WHERE FolderId=?");
			$statement->bindValue(1, $folderId);
			$statement->execute();
			foreach ($statement->fetchAll() as $DBFile)
			{
				$file = new File($DBFile["Id"], $folderId, $DBFile["Name"], $DBFile["Extension"], NULL);
				$folder->files[] = $file;
			}

			return $folder;
		}
	}

	public function createFolder($name, $parentFolderId)
	{
		$statement = $this->pdo->prepare("INSERT INTO folder (Name, ParentFolderId) VALUES (?,?)");
		$statement->bindValue(1, $name);
		$statement->bindValue(2, $parentFolderId);
		$statement->execute();

		return $this->pdo->lastInsertId();
	}

	public function deleteFolder($folderId)
	{
		$statement = $this->pdo->prepare("DELETE folder WHERE Id=?");
		$statement->bindValue(1, $folderId);
		$statement->execute();
	}

	public function uploadFile($data, $filename, $extension, $folderId)
	{
		// save to db
		$statement = $this->pdo->prepare("INSERT INTO file (FolderId, Name, Extension) VALUES (?,?,?)");
		$statement->bindValue(1, $folderId);
		$statement->bindValue(2, htmlspecialchars($filename));
		$statement->bindValue(3, htmlspecialchars($extension));
		$statement->execute();
		// save file on server
		file_put_contents($fileId . "txt", $data);
	}

	public function deleteFile($fileId)
	{
		$statement = $this->pdo->prepare("DELETE file WHERE Id=?");
		$statement->bindValue(1, $fileId);
		$statement->execute();
	}

	public function getFile($fileId)
	{
		$statement = $this->pdo->prepare("SELECT Name, Extension FROM file WHERE Id=?");
		$statement->bindValue($fileId);
		$statement->execute();
		$result = $statement->fetch();
		$file = new File($folderId, $result["Name"], $result["Extension"], NULL);
		// get file from server
		$filename = $fileId . "txt";

		$savedFile = fopen($filename, "r") or die();
		$file->data = fread($savedFile, filesize($savedFile));
		fclose($savedFile);

		return $file;
	}

	public function createAccessToFile($fileId, $userId)
	{
		$statement = $this->pdo->prepare("INSERT INTO userFileRelease (UserId, FileId) VALUES (?,?)");
		$statement->bindValue(1, $userId);
		$statement->bindValue(2, $fileId);
		$statement->execute();
	}

	public function userHasAccessToFile($fileId, $parentFolderId, $userId)
	{
		$statement = $this->pdo->prepare("SELECT * FROM userFileRelease WHERE UserId=? AND FileId=?");
		$statement->bindValue(1, $userId);
		$statement->bindValue(2, $fileId);
		$statement->execute();
		
		return ($statement->rowCount() == 1 || $this->userHasAccessToFolder($parentFolderId));
	}

	public function createAccessToFolder($folderId, $userId)
	{
		$statement = $this->pdo->prepare("INSERT INTO userFolderRelease (UserId, FolderId) VALUES (?,?)");
		$statement->bindValue(1, $userId);
		$statement->bindValue(2, $folderId);
		$statement->execute();
	}

	// checks if user has acces to this folder or to one of the parent folders
	public function userHasAccessToFolder($folderId, $userId)
	{
		return true;
		// https://stackoverflow.com/questions/16513418/how-to-do-the-recursive-select-query-in-mysql
		$query = "CREATE PROCEDURE ";
		$statement = $this->pdo->prepare(query);
		$statement->bindValue(1, $userId);
		$statement->bindValue(1, $folderId);
	}
}
