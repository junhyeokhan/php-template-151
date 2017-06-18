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
  		
  		if ($budget != 0)
  		{
  			$data = array();
  			$data['year'] = $year;
  			$data['month'] = $month;
  			$data['budget'] = $budget;
  			
  			$data['categories'] = $this->budgetService->getAllCategories();
  			
  			echo $this->template->render("budget.html.php", $data);
  		}
  		else
  		{
  			$_SESSION["errorMessage"]["configuration"] = "Please define your configuration first!";
  			header("Location: /configuration");
  		}
  	}
  	else 
  	{
  		//not authorized
  	}
  }
  
  public function saveEntry($email, $data)
  {
  	$date = $data['date'];
  	$amountOfMoney = $data['amountOfMoney'];
  	$description = $data['description'];
  	$categoryId = $data['category'];
  	
  	if ($this->budgetService->saveEntry($email, $date, $amountOfMoney, $description, $categoryId))
  	{
  		header("Location: /budget");
  	}
  	else
  	{
  	 //error	
  	}
  }
}
