<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Statistics\StatisticsService;
use junhyeokhan\Service\Configuration\ConfigurationPdoService;
use junhyeokhan\Service\Budget\BudgetPdoService;

class StatisticsController 
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $configurationService;
  private $budgetService;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, ConfigurationPdoService $configurationPdoService, BudgetPdoService $budgetPdoService)
  {
     $this->template = $template;
     $this->configurationService = $configurationPdoService;
     $this->budgetService = $budgetPdoService;
  }
  
  public function getStatistics($email, $year, $month)
  {
  	$statistics = array();
  	
  	$configuration = $this->configurationService->getConfiguration($email);
  	
  	if (count($configuration) > 0)
  	{
  		$budgetThisMonth = $this->budgetService->getBudget($email, $year, $month);
  	
	  	//Monthly amount statistic
	  	$totalAmount = $configuration[0]['monthlyBudget'];
	  	
	  	$usedAmount = 0;
	  	
	  	foreach	($budgetThisMonth as $entry)
	  	{
	  		$usedAmount += $entry['amountOfMoney'];
	  	}
	  	
	  	if ($totalAmount >= $usedAmount)
	  	{
	  		$freeAmount = $totalAmount - $usedAmount;
	  		$exceededAmount = 0;
	  	}
	  	else
	  	{
	  		$freeAmount = 0;
	  		$exceededAmount = $usedAmount - $totalAmount;
	  	}
	  	
	  	$statistics['monthly']['free'] = $freeAmount;
	  	$statistics['monthly']['used'] = $usedAmount;
	  	$statistics['monthly']['over'] = $exceededAmount;
	  	
	  	//Monthly category statistic  	
	  	$allCategories = array_column($budgetThisMonth, 'name');
	
	  	foreach ($allCategories as $category)
	  	{
	  		$statistics['categories'][$category] = 0;
		  	foreach	($budgetThisMonth as $entry)
		  	{
		  		if ($entry['name'] == $category)
		  		{
		  			$statistics['categories'][$category] += $entry['amountOfMoney'];
		  		}
		  	}
	  	}
	  	
	  	return $statistics;
  	}
  	else
  	{
  		header("Location: /configuration");
  	}
  }
}
