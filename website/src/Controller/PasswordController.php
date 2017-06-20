<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Password\PasswordServiceInterface;

class PasswordController
{
	private $template;
	private $passwordService;
	
	public function __construct(SimpleTemplateEngine $template, PasswordServiceInterface $passwordService)
	{
		$this->template = $template;
		$this->passwordService = $passwordService;
	}
	
	public function showForgotPassword()
	{
		echo $this->template->render("forgotPassword.html.php");
	}
	
	public function sendResetEmail(array $data)
	{
		// Handles invalid request
		if (!array_key_exists("email", $data))
		{
			// Do nothing
		}
		else
		{
			if ($this->passwordService->sendResetEmail($data["email"]))
			{
				header ( "Location: /login" );
			}
			else
			{
				$_SESSION["forgotpassword"]["error"] = "Sending link failed! Please try again! <br />";
				$this->showForgotPassword();
			}
		}
	}
	
	public function verifyResetHash($key)
	{
		return $this->passwordService->getEmailByResetKey($key);
	}
	
	public function showResetPassword($email, $key)
	{
		$data = array();
		$data ['email'] = $email;
		$data ['key'] = $key;
		
		echo $this->template->render("resetPassword.html.php", $data);
	}
	
	public function updatePassword($email, $password)
	{
		$this->passwordService->updatePassword($email,$password);
		header("Location: /login");
	}
}
