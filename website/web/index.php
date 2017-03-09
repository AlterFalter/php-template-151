<?php

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new ihrname\SimpleTemplateEngine(__DIR__ . "/../templates/");

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new ihrname\Controller\IndexController($tmpl))->homepage();
		break;
	case "/testrout":
		echo "test";
		break;
	default:
		// Begrüsst User
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new ihrname\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

