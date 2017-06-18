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
  			$_SESSION["configuration"]["error"] = "Please define your configuration first!";
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
  	if ($this->budgetService->saveEntry($data, $email))
  	{
  		header("Location: /budget");
  	}
  	else
  	{
  	 //error	
  	}
  }
  
  public function editEntry($entry_Id)
  {
  	$data['entry'] = $this->budgetService->getEntry($entry_Id)[0];
  	$data['categories'] = $this->budgetService->getAllCategories();  	
  	
  	echo $this->template->render("editBudget.html.php", $data);
  }
  
  public function deleteEntry($entry_Id)
  {
  	$data['categories'] = $this->budgetService->deleteEntry($entry_Id);
  	header("Location: /budget");
  }
}
