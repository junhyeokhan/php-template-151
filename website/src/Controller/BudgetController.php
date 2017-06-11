<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Budget\BudgetServiceInterface;

class BudgetController
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $budgetService;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, BudgetServiceInterface $budgetService)
  {
     $this->template = $template;
     $this->budgetService = $budgetService;
  }
  
  public function showBudget($year, $month)
  {
  	if (isset($_SESSION['user']['email']))
  	{
  		$email = $_SESSION['user']['email'];
  		
  		$budget = $this->budgetService->getBudget($email, $year, $month);
  	}
  	else 
  	{
  		//not authorized
  	}
  }
}
