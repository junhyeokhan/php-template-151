<?php
// PHP will show all error messages
error_reporting ( E_ALL ); 
session_start ();

// Autoloading
require_once ("../vendor/autoload.php"); 

$config = parse_ini_file ( __DIR__ . "/../config.ini", true );
$factory = new junhyeokhan\Factory ( $config );

// Prevent dot dot slash attack
if (strpos($_SERVER["REQUEST_URI"], "../") !== false)
{
	header ( "HTTP/1.1 400 Bad Request" );
}

// Handle parameters
if (strpos($_SERVER["REQUEST_URI"], '?') !== false) 
{
	$requestController = explode('?', $_SERVER["REQUEST_URI"])[0];
	$requestParameters = explode('?', $_SERVER["REQUEST_URI"])[1];
}
else
{
	$requestController = $_SERVER["REQUEST_URI"];
}

switch ($requestController) 
{
	case "/login":
		unset($_SESSION["login"]);
		$loginController = $factory->getLoginController();
		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$loginController->showLogin(array());
		}
		else
		{
			$loginController->login($_POST);
		}
		break;
	
	case "/logout":
		unset($_SESSION['user']);
		header("Location: /");
		break;
	
	case "/register":
		unset($_SESSION["register"]);
		$controller = $factory->getRegisterController();
		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$controller->showRegister(array());
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
			if ($_SERVER["REQUEST_METHOD"]=== "GET") 
			{
				$controller->showBudget(date('Y'), date('m'));
			} 
			else 
			{
				$submit = $_POST["submit"];
				if ($submit == "new" || $submit == "save")
				{
					$controller->saveEntry($_SESSION["user"]["email"], $_POST);
				}
				else if (strpos($submit, "edit") !== false)
				{
					$entryId = explode('-', $submit)[1];
					$controller->editEntry($entryId);
				}
				else if (strpos($submit, "edit") !== false)
				{
					$entryId = explode('-', $submit)[1];
					$controller->deleteEntry($entryId);
				}
				else if ($submit == "cancel")
				{
					header("Location: /budget");
				}
			}
		} 
		else 
		{
			header("Location: /login");
		}		
		break;
	
	case "/configuration":
		if (isset($_SESSION["user"]))
		{
			unset($_SESSION["configuration"]);
			$controller = $factory->getConfigurationController();
			if ($_SERVER["REQUEST_METHOD"] === "GET")
			{
				$controller->showConfiguration(array());
			}
			else 
			{
				$controller->saveConfiguration($_POST);
			}
		}
		else
		{
			header("Location: /login");
		}
		break;
		
	case "/forgotpassword":
		{
			if (!isset($_SESSION["user"]))
			{
				$controller = $factory->getPasswordController();
				if ($_SERVER["REQUEST_METHOD"] === "GET")
				{
					$controller->showForgotPassword();
				}
				else
				{
					$controller->sendResetEmail($_POST);
				}
			}
			else
			{
				header("Location: /");
			}
		}
		break;
		
	case "/resetpassword":
		{
			if (!isset($_SESSION["user"]))
			{
				$controller = $factory->getPasswordController();
				if ($_SERVER["REQUEST_METHOD"] === "GET") 
				{
					$email = $controller->verifyResetHash($requestParameters);
					if (!empty($email))
					{
						$controller->showResetPassword($email, $requestParameters);
					}
					else 
					{
						header ( "HTTP/1.1 400 Bad Request");
					}
				}
				else
				{
					$dbEmail = $controller->verifyResetHash($_POST["key"]);
				
					if ($dbEmail == $_POST["email"])
					{
						$controller->updatePassword($_POST["email"], $_POST["password"]);
					}
					else
					{
						header ( "HTTP/1.1 400 Bad Request");
					}
				}
			}
		}
		break;
		
	default: 
		// Homepage
		$statistics = array();
		if (isset($_SESSION ["user"]))
		{
			$statistics = $factory->getStatisticsController()->getStatistics($_SESSION["user"]["email"], date( 'Y' ), date('m'));
		}
		$factory->getIndexController()->renderHompage($statistics);
		break;
}
?>