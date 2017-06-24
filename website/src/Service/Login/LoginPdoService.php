<?php 

namespace AlterFalter\Service\Login;

use AlterFalter\Service\Login\LoginService;
use AlterFalter\Models\User;

class LoginPdoService implements LoginService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function encodePassword($plainPassword)
	{
		return password_hash($plainPassword, PASSWORD_DEFAULT);
	}
	
	public function authenticate($email, $password) 
	{
		$statement = $this->pdo->prepare("SELECT Password FROM user WHERE Email=?");
		$statement->bindValue(1, $email);
		$statement->execute();
		
		return password_verify($password, $statement->fetch()["Password"]);
	}

	public function DoesEmailAlreadyExist($email)
	{
		$statement = $this->pdo->prepare("SELECT * FROM user WHERE Email=?");
		$statement->bindValue(1, $email);
		$statement->execute();

		return $statement->rowCount() != 0;
	}

	public function registerUser(User $user, $guid)
	{
		try 
		{
			$this->pdo->beginTransaction();

			// create folder
			$statement = $this->pdo->prepare("INSERT INTO folder (Name) VALUES (?)");
			$statement->bindValue(1, "My folder");
			$statement->execute();

			$folderId = $this->pdo->lastInsertId();

			// create user
			$statement = $this->pdo->prepare("INSERT INTO user (MainFolderId, Email, Firstname, Surname, Password, GuidForEmail, EmailVerified) VALUES (?,?,?,?,?,?,?)");
			$statement->bindValue(1, $folderId);
			$statement->bindValue(2, $user->email);
			$statement->bindValue(3, $user->firstname);
			$statement->bindValue(4, $user->surname);
			$statement->bindValue(5, $this->encodePassword($user->password));
			$statement->bindValue(6, $guid);
			$statement->bindValue(7, false);
			$statement->execute();

			$userId = $this->pdo->lastInsertId();

			$this->pdo->commit();

			return $userId;
		}
		catch (\PDOException $e)
		{
			$this->pdo->rollback();
			return 0;
		}

		return $statement->rowCount() != 0;
	}

	public function emailVerification($guid)
	{
		$statement = $this->pdo->prepare("SELECT id FROM user WHERE guid=?");
		$statement->bindValue(1, $guid);
		$statement->execute();

		return ($statement->rowCount() == 1);
	}

	public function passwordGuidExists($userId, $guid)
	{
		if (strlen($guid) < 36)
		{
			return false;
		}
		$statement = $this->pdo->prepare("SELECT * FROM user WHERE Id=? AND GuidForNewPW=?");
		$statement->bindValue(1, $userId);
		$statement->bindValue(2, $guid);
		$statement->execute();

		return ($statement->rowCount() == 1);
	}

	public function getUserId($email)
	{
		$statement = $this->pdo->prepare("SELECT Id FROM user WHERE Email=?");
		$statement->bindValue(1, $email);
		$statement->execute();
		return $statement->fetch()["Id"];
	}

	public function setNewPassword($id, $guid, $password)
	{
		$statement = $this->pdo->prepare("UPDATE user SET Password=?, GuidForNewPW=NULL WHERE Id=? AND GuidForNewPW=?");
		$statement->bindValue(1, $this->encodePassword($password));
		$statement->bindValue(2, $id);
		$statement->bindValue(3, $guid);
		$statement->execute();
	}

	public function savePasswordGuid($userId, $guid)
	{
		$statement = $this->pdo->prepare("UPDATE user SET GuidForNewPW=? WHERE Id=?");
		$statement->bindValue(1, $guid);
		$statement->bindValue(2, $userId);
		$statement->execute();
	}
}
