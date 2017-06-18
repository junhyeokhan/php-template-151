<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Register\RegisterPdoService;

class RegisterController 
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $registerService;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, RegisterPdoService $registerService)
  {
     $this->template = $template;
     $this->registerService = $registerService;
  }
  
  public function showRegister()
  {
  	echo $this->template->render("register.html.php");
  }
  
  public function showConfiguration()
  {
  	echo $this->template->render("configuration.html.php");
  }
  
  public function register(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data))
  	{
  		$this->showRegister();
  		return;
  	}
  	
  	if ($this->registerService->register($data["email"], $data["password"], $data["firstName"], $data["lastName"],  $data["gender"], $data["dateOfBirth"]))
  	{
  		$_SESSION["register"]["success"] = "Register succeeded!";
  		header("Location: \login");
  	} else {
  		$_SESSION["register"]["errorMessage"] = "Register failed! Please try again!";
  		$this->Register();
  	}
  	
  }
}
