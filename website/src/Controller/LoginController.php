<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;

class LoginController 
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template)
  {
     $this->template = $template;
  }
  
  public function showLogin()
  {
  	echo $this->template->render("login.html.php");
  }
}
