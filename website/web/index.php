<?php
error_reporting(E_ALL); //PHP will show all error messages
session_start();

require_once("../vendor/autoload.php"); //Autoloading 

$config = parse_ini_file(__DIR__ . "/../config.ini", true);

$factory = new junhyeokhan\Factory($config);

//TODO: Counter dotdotslash

//If request with paramenters
if (strpos($_SERVER["REQUEST_URI"], '?') !== false)
{
	$requestController = explode('?',$_SERVER["REQUEST_URI"])[0];
	$requestParameters = explode('?',$_SERVER["REQUEST_URI"])[1];
}
else
{
	$requestController = $_SERVER["REQUEST_URI"];
}

switch($requestController) {	
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
		$loginController = $factory->getLoginController();
		
		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$loginController->showLogin();
		}
		else
		{
			$loginController->login($_POST);
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
	case "/forgotpassword":
		{
			$loginController = $factory->getLoginController();
			
			if ($_SERVER["REQUEST_METHOD"] === "GET")
			{
				$loginController->showForgotPassword();
			}
			else
			{
				$loginController->sendResetEmail($_POST);
			}
		}
		break;
	case "/resetpassword":
		{
			$loginController = $factory->getLoginController();
			if ($_SERVER["REQUEST_METHOD"] === "GET")
			{
				$email = $loginController->verifyResetHash($requestParameters);
				
				if (!empty($email))
				{
					$loginController->showResetPassword($email, $requestParameters);
				}
				else
				{
					header("HTTP/1.1 404 Not Found");
				}
			}
			else
			{
				$email = $_POST['email'];
				$key = $_POST['key'];
				$password = $_POST['password'];
				
				$decryptedEmail = $loginController->verifyResetHash($key);
				
				if ($decryptedEmail == $email)
				{
					$loginController->updatePassword($email, $password);
				}
				else
				{
					//User edited hidden field (email or key)
					header("HTTP/1.1 404 Not Found");
				}
			}
			
			
		}
		break;
	default:
		header("HTTP/1.1 404 Not Found");
}
?>