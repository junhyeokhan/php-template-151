<?php
namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Register\RegisterServiceInterface;

class RegisterController 
{
	private $template;
	private $registerService;
	
	public function __construct(SimpleTemplateEngine $template, RegisterServiceInterface $registerService)
	{
		$this->template = $template;
		$this->registerService = $registerService;
	}
	
	public function showRegister($data)
	{
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("register.html.php", $data);
	}
	
	public function register(array $data)
	{
		if ($_SESSION["csrf"] == $data["csrf"])
		{
			// Someone might try hacking -> No hint but the page will be given again
			if (!array_key_exists ("email", $data) OR 
					!array_key_exists("password", $data) OR 
					!array_key_exists("firstName", $data) OR 
					!array_key_exists("lastName", $data) OR 
					!array_key_exists("gender", $data) OR 
					!array_key_exists("dateOfBirth", $data))
			{
				// Do nothing
			}
			else
			{
				// Check if there is any empty field
				$errorMessage = '';
				if (empty($data["email"]) || !isset($data["email"]))
				{
					$errorMessage .= "Email is not entered!<br />";
				}
				if (empty($data["password"]) || !isset($data["password"]))
				{
					$errorMessage .= "Password is not entered!<br />";
				}
				if (empty($data["firstName"]) || !isset($data["firstName"]))
				{
					$errorMessage .= "First name is not entered!<br />";
				}
				if (empty($data["lastName"]) || !isset($data["lastName"]))
				{
					$errorMessage .= "Last name is not entered!<br />";
				}
				if (empty($data["gender"]) || !isset($data["gender"]))
				{
					$errorMessage .= "Gender is not selected!<br />";
				}
				if (empty($data["dateOfBirth"]) || !isset($data["dateOfBirth"]))
				{
					$errorMessage .= "Date of birth is not selected!<br />";
				}
				
				if (!empty($errorMessage))
				{
					$_SESSION["register"]["error"] = $errorMessage;
					$this->showRegister($data);
				}
				else
				{
					if ($this->registerService->register(
							htmlentities($data["email"]), 
							htmlentities($data["password"]), 
							htmlentities($data["firstName"]), 
							htmlentities($data["lastName"]), 
							htmlentities($data["gender"]), 
							htmlentities($data["dateOfBirth"])))
					{
						header("Location: \login");
					}
					else
					{
						$this->showRegister($data);
					}
				}
			}
		}
  	}
}
