<?php

error_reporting(E_ALL);
session_start();

require_once("../vendor/autoload.php");
require_once("../src/ErrorType.php");

$factory = AlterFalter\Factory::createFromIniFile(__DIR__ . "/../config.ini");

$isGet = $_SERVER['REQUEST_METHOD'] === "GET";
$isPost = $_SERVER['REQUEST_METHOD'] === "POST";


$uri = strtok(
	$_SERVER["REQUEST_URI"],
	"?"
);

switch(strtolower($uri)) {
	case "/":
	case "/index":
	case "/home":
		$factory->getIndexController()->home();
		break;
	case "/aboutus":
		$factory->getIndexController()->aboutus();
		break;
	case "/login":
		if($isGet)
		{
			$factory->getLoginController()->loginGET();
		}
		else if ($isPost)
		{
			$factory->getLoginController()->loginPOST($_POST);
		}
		break;
	case "/register":
		if ($isGet)
		{
			$factory->getLoginController()->registerGET();
		}
		else if ($isPost)
		{
			$factory->getLoginController()->registerPOST($_POST);
		}
		break;
	case "/logout":
		$factory->getLoginController()->logout();
		break;
	case "/forgotpassword":
		if($isGet) {
			$factory->getLoginController()->forgotPasswordGET();
		}
		else
		{
			$factory->getLoginController()->forgotPasswordPOST($_POST);
		}
		break;
	case "/setpassword":
		if ($isGet)
		{
			$factory->getLoginController()->setNewPasswordGET($_GET);
		}
		else
		{
			$factory->getLoginController()->setNewPasswordPOST($_POST);
		}
		break;
	case "/drive":
		$factory->getDriveController()->folder($_GET);
		break;
	case "/download":
		$factory->getDriveController()->download($_POST);
		break;
	case "/renamefolder":
		$factory->getDriveController()->renamefolder($_POST);
		break;
	case "/renamefile":
		$factory->getDriveController()->renamefile($_POST);
		break;
	case "/relocatefolder":
		$factory->getDriveController()->relocatefolder($_POST);
		break;
	case "/relocatefile":
		$factory->getDriveController()->relocatefile($_POST);
		break;
	default:
		$factory->getErrorController()->error(
			ErrorType::NotFound,
			"Requested site not found!"
		);
		break;
}

