<?php
error_reporting(E_ALL); //PHP will show all error messages
session_start();

require_once("../vendor/autoload.php"); //Autoloading 

$config = parse_ini_file(__DIR__ . "/../config.ini", true);

$factory = new junhyeokhan\Factory($config);

switch($_SERVER["REQUEST_URI"]) {
	case "/": //Homepage
		$factory->getIndexController()->homepage();
		break;
		
	case "/login":
		$cnt = $factory->getLoginController();
		
		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$cnt->showLogin();
		}
		else
		{
			$cnt->login($_POST);
		}
		break;
		
	//../../../../../../../../../etc/passwd
	case "/weak":
		$template = 'hello.html.php';
		if (isset($_COOKIE['TEMPLATE']))
   			$template = $_COOKIE['TEMPLATE'];
		else 
			setcookie('TEMPLATE', $template);
		include (__DIR__ . "/../templates/" . $template);
		break;
		
	case "/strong":
		$template = 'hello.html.php';
		if (isset($_COOKIE['TEMPLATE']))
			$template = $_COOKIE['TEMPLATE'];
			else
				setcookie('TEMPLATE', $template);
		if (preg_match('#\.\./#', $template)) {
			header("HTTP/1.1 403 Forbidden");
			die();
		}
		include (__DIR__ . "/../templates/" . $template);
		break;
		
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

?>