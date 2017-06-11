<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Configuration\ConfigurationPdoService;

class ConfigurationController
{
  /**
   * @var junhyeokhan\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $configurationService;
  
  /**
   * @param junhyeokhan\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, ConfigurationPdoService $configurationService)
  {
     $this->template = $template;
     $this->configurationService = $configurationService;
  }
  
  public function showConfiguration()
  {
  	if (isset($_SESSION['user']['email']))
  	{
  		$email = $_SESSION['user']['email'];
  		$configuration = $this->configurationService->getConfiguration($email);
  		
  		
  		
  		if (count($configuration) > 0)
  		{
  			echo $this->template->render("configuration.html.php", $configuration[0]);
  		}
  		else
  		{
  			echo $this->template->render("configuration.html.php");
  		}
  	}
  	else
  	{
  		//not authorized
  	}
  }
  
  public function saveConfiguration(array $data)
  {
  	if (isset($_SESSION['user']['email']))
  	{
  		$email = $_SESSION['user']['email'];
  		if (isset($data['monthlyBudget']) && isset($data['resetType']))
  		{
  			$monthlyBudget = $data['monthlyBudget'];
  			$resetType = $data['resetType'];
  		
  			if (isset($data['resetDate']))
  			{
  				$resetDate = $data['resetDate'];
  			}
  			else
  			{
  				$resetDate = 0;
  			}
  		
  			if (floatval($monthlyBudget) <= 0)
  			{
  				//validation error
  			}
  			if ($resetType == 'userDate' && $resetDate == 0)
  			{
  				//validation error
  			}
  		
  			$this->configurationService->saveConfiguration($email, $monthlyBudget, $resetType, $resetDate);
  			
  			header('Location: /configuration');
  		}
  		else
  		{
  			//validation error
  		}
  	}
  	else 
  	{
  		//validation error
  	}
  }
}
