<?php

error_reporting(E_ALL); //PHP will show all error messages
use ihrname\Controller\LoginController;
require_once("../vendor/autoload.php"); //Autoloading 
$tmpl = new ihrname\SimpleTemplateEngine(__DIR__ . "/../templates/"); //For building webpages

switch($_SERVER["REQUEST_URI"]) {
	case "/": //Homepage
		(new ihrname\Controller\IndexController($tmpl))->homepage();
		break;
	case "/login":
		(new LoginController($tmpl))->showLogin();
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new ihrname\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

?>