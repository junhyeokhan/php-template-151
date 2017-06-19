<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Login\LoginServiceInterface;

class LoginController 
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $loginService;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, LoginServiceInterface $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }
  
  public function showLogin()
  {
  	echo $this->template->render("login.html.php");
  }

  public function showForgotPassword()
  {
  	 echo $this->template->render("forgotPassword.html.php");
  }
  
  public function login(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data))
  	{
  		$this->showLogin();
  		return;
  	}
  	
  	if ($this->loginService->authenticate($data["email"], $data["password"]))
  	{
  			header("Location: /");
  	} else {
  		echo $this->template->render("login.html.php", ["email" => $data["email"]]);
  	}
  }
  
  public function logout()
  {
  	unset($_SESSION['user']);
  }
  
  public function sendResetEmail(array $data)
  {
  	//Handles invalid request
  	if (!array_key_exists("email", $data))
  	{
  		$this->showForgotPassword();
  	}
  	
  	$this->loginService->sendResetEmail($data["email"]);
  	  	
  	header("Location: /login");
  }
  
  public function verifyResetHash($requestParameters)
  {
  	if (strpos($requestParameters, "key=") !== false)
  	{
  		$key = explode("key=",$_SERVER["REQUEST_URI"])[1];
  		  		
  		return $this->loginService->getEmailByResetKey($key);
  	}
  }
  
  public function showResetPassword($email, $key)
  {
  	$data = array();
	$data['email'] = $email;
	$data['key'] = $key;
				
  	echo $this->template->render("resetPassword.html.php", $data);
  }
  
  public function updatePassword($email, $password)
  {
  	$this->loginService->updatePassword($email, $password);
	header("Location: /login");
  }
}
