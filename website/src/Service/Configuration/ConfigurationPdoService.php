<?php

namespace junhyeokhan\Service\Configuration;

class ConfigurationPdoService implements ConfigurationServiceInterface 
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function getConfiguration($email)
	{
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$query->execute([$email]);
		
		if ($query->rowCount() > 0)
		{
			$userId = $query->fetchColumn(0);
			
			$query = $this->pdo->prepare("SELECT * FROM configuration WHERE user_Id=?");
			$query->execute([$userId]);
			
			return $query->fetchAll();
		}
		else
		{
			$_SESSION["configuration"]["error"] = "User is not found!";
		}
	}
	
	public function saveConfiguration($email, $monthlyBudget, $resetType, $resetDate)
	{
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$query->execute([$email]);
		
		if ($query->rowCount() > 0)
		{
			$userId = $query->fetchColumn(0);
			
			$query = $this->pdo->prepare("SELECT * FROM configuration WHERE user_Id=?");
			$query->execute([$userId]);
			
			$configuration = $query->fetchAll();
			
			if (count($configuration) > 0)
			{
				$query = $this->pdo->prepare("UPDATE configuration SET monthlyBudget=?, resetType=?, resetDate=? WHERE user_Id=?");
				$query->execute([floatval($monthlyBudget), $resetType, $resetDate, $userId]);
			}
			else
			{
				$query = $this->pdo->prepare("INSERT INTO configuration (user_Id, monthlyBudget, resetType, resetDate) VALUES (?, ?, ?, ?)");
				$query->execute([$userId, floatval($monthlyBudget), $resetType, $resetDate]);
			}
		
			return $query->rowCount() == 0;
		}
		else
		{
			$_SESSION["configuration"]["error"] = "User is not found!";
		}
	}
}
