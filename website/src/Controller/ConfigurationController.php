<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Configuration\ConfigurationServiceInterface;

class ConfigurationController
{
	private $template;
	private $configurationService;
	
	public function __construct(SimpleTemplateEngine $template, ConfigurationServiceInterface $configurationService)
	{
		$this->template = $template;
		$this->configurationService = $configurationService;
	}
	
	public function showConfiguration($data) 
	{
		$_SESSION["configuration"]["csrf"] = bin2hex(random_bytes(50));		
		if (isset($_SESSION["user"]["email"]))
		{
			$configuration = $this->configurationService->getConfiguration($_SESSION["user"]["email"]);
			
			if (count($configuration) > 0)
			{
				echo $this->template->render("configuration.html.php", $configuration[0]);
			}
			else
			{
				echo $this->template->render("configuration.html.php", $data);
			}
		}
		else
		{
			header("Location: /login");
		}
	}
	
	public function saveConfiguration(array $data)
	{
		if ($_SESSION["configuration"]["csrf"] == $data["csrf"])
		{
			if (!isset($_SESSION["user"]["email"]))
			{
				header("Location: /login");
			}
			else
			{
				$email = $_SESSION ["user"]["email"];
				if (isset($data["monthlyBudget"]) && isset($data["resetType"]))
				{
					$monthlyBudget = $data["monthlyBudget"];
					$resetType = $data["resetType"];
					$resetDate = 0;
					
					if (isset($data['resetDate']))
					{
						$resetDate = $data['resetDate'];
					}
					
					$errorMessage = '';				
					if (floatval($monthlyBudget) <= 0)
					{
						$errorMessage .= "Invalid number for monthly budget is entered! <br />";
					}
					if ($resetType == 'userDate' && $resetDate == 0)
					{
						$errorMessage .= "Reset date is not entered! <br />";
					}
					
					if (!empty($errorMessage))
					{
						$_SESSION["configuration"]["error"] = $errorMessage;
						$this->showConfiguration($data);
						return 0;
					}
					
					if ($this->configurationService->saveConfiguration(
							htmlentities($email), 
							htmlentities($monthlyBudget), 
							htmlentities($resetType), 
							htmlentities($resetDate)))
					{
						header("Location: /configuration");
					}
					else
					{
						$this->showConfiguration($data);
						return 0;
					}
				}
				else 
				{
					$_SESSION["configuration"]["error"] = "Please enter monthly budget and select reset type!";
					return 0;
				}
	  		}
		}
	}
}
