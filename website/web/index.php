<?php

use AlterFalter;

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new AlterFalter\SimpleTemplateEngine(__DIR__ . "/../templates/");

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new AlterFalter\Controller\IndexController($tmpl))->homepage();
		break;
	case "/login":
			(new AlterFalter\Controller\LoginController($tmpl))->showLogin();
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

