<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;

class IndexController 
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

  public function renderHompage() {
  	echo $this->template->render("home.html.php");
  }
}
