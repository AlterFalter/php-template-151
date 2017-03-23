<?php

use AlterFalter\Controller;

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new AlterFalter\SimpleTemplateEngine(__DIR__ . "/../templates/");
$pdo = new \PDO(
			"mysql:host=mariadb;dbname=app;charset=utf8",
			"root",
			"my-secret-pw",
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		);


switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new Controller\IndexController($tmpl))->homepage();
		break;
	case "/login":
			$controller = (new Controller\LoginController($tmpl, $pdo));
			if($_SERVER['REQUEST_METHOD'] === "GET") {
				$controller->showLogin();
			}
			else {
				$controller->login($_POST);
			}
			break;
	default:
		// Begrüsst User
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new AlterFalter\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

