<?php
error_reporting(E_ALL); //PHP will show all error messages
session_start();

require_once("../vendor/autoload.php"); //Autoloading 

$config = parse_ini_file(__DIR__ . "/../config.ini", true);

$factory = new junhyeokhan\Factory($config);

switch($_SERVER["REQUEST_URI"]) {
	case "/": //Homepage
		if (isset($_SESSION["user"]))
		{
			$statistics = $factory->getStatisticsController()->getStatistics($_SESSION["user"]["email"], date("Y"), date("m"));
		}
		else
		{
			$statistics = array();
		}
		$factory->getIndexController()->renderHompage($statistics);
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
		
	case "/logout":
		$controller = $factory->getLoginController();
		$controller->logout();

		$factory->getIndexController()->renderHompage(array());
		break;
		
	case "/register":
		$controller = $factory->getRegisterController();
		
		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$controller->showRegister();
		}
		else
		{
			$controller->register($_POST);
		}
		break;
	
	case "/budget":
		if (isset($_SESSION["user"]))
		{
			$controller = $factory->getBudgetController();
			if ($_SERVER["REQUEST_METHOD"] === "GET")
			{
				$controller->showBudget(date("Y"), date("m"));
			}
			else
			{
				$submit = $_POST['submit'];
				if (strpos($submit, 'saveEdit') !== false)
				{
					$controller->saveEntry($_SESSION["user"]["email"], $_POST);
				}
				else if (strpos($submit, 'edit') !== false)
				{
					$controller->editEntry(explode("-", $submit)[2]);
				}
				else if (strpos($submit, 'new') !== false)
				{
					$controller->saveEntry($_SESSION["user"]["email"], $_POST);
				}
				else if (strpos($submit, 'delete') !== false)
				{
					$controller->deleteEntry(explode("-", $submit)[2]);
				}
			}
		}
		else
		{
			$controller = $factory->getLoginController();
			$controller->showLogin();
		}
		
		break;
		
	case "/configuration":
		if (isset($_SESSION["user"]))
		{
			$controller = $factory->getConfigurationController();
			if ($_SERVER["REQUEST_METHOD"] === "GET")
			{
				$controller->showConfiguration();
			}
			else
			{
				$controller->saveConfiguration($_POST);
			}
		}
		else
		{
			$controller = $factory->getLoginController();
			$controller->showLogin();
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
		header("HTTP/1.1 404 Not Found");
}

?>