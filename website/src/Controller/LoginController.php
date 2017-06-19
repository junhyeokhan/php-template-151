<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Login\LoginServiceInterface;

class LoginController 
{
	private $template;
	private $loginService;
	
	public function __construct(SimpleTemplateEngine $template, LoginServiceInterface $loginService)
	{
		$this->template = $template;
		$this->loginService = $loginService;
	}
	
	public function showLogin(array $data)
	{
		$_SESSION["login"]["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("login.html.php", $data);
	}
	
	public function login(array $data)
	{
		if ($_SESSION["register"]["csrf"] == $data["csrf"])
		{
			// Someone might try hacking -> No hint but the page will be given again
			if (!array_key_exists("email", $data) OR !array_key_exists ("password", $data))
			{
				// Do nothing
			}
			
			// Check if there is any empty field
			$errorMessage = '';
			if (empty($data["email"]) || !isset($data["email"])) 
			{
				$errorMessage .= "Email is not entered!<br />";
			}
			if (empty ( $data ["password"] ) || ! isset ( $data ["password"] )) {
				$errorMessage .= "Password is not entered!<br />";
			}
			
			if (!empty($errorMessage))
			{
				$_SESSION["login"]["error"] = $errorMessage;
				$this->showLogin($data);
			}
			else
			{
				if ($this->loginService->authenticate(
						htmlentities($data["email"]), 
						htmlentities($data["password"]))) 
				{
					header("Location: /");
				}
				else
				{
					echo $this->showLogin($data);
				}
			}
		}
	}
}
