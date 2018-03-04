<?php

namespace AlterFalter\Service\Login;

use AlterFalter\Models\User;
	
interface LoginService
{
	public function authenticate($username, $password);
	public function DoesEmailAlreadyExist($email);
	public function registerUser(User $user, $guid);
	public function passwordGuidExists($userId, $guid);
	public function savePasswordGuid($userId, $guid);
	public function emailVerification($guid);
	public function getUserId($email);
	public function setNewPassword($userId, $guid, $password);
}

// no end tag --> because it will be read as html