<?php

namespace junhyeokhan\Service\Configuration;

class ConfigurationPdoService implements ConfigurationServiceInterface
{
	/**
	 * @var \PDO
	 */
	private $pdo;
	
	/**
	 * @param \PDO
	 */
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function getConfiguration($email)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->execute([$email]);
		if ($stmt->rowCount() > 0)
		{
			$userId = $stmt->fetchColumn(0);
				
			$stmt = $this->pdo->prepare("SELECT * FROM configuration WHERE user_Id=?");
			$stmt->execute([$userId]);
			
			return $stmt->fetchAll();
		}
		else
		{
			//error message
		}
	}
	
	public function saveConfiguration($email, $monthlyBudget, $resetType, $resetDate)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$stmt->execute([$email]);
		
		if ($stmt->rowCount() > 0)
		{
			$userId = $stmt->fetchColumn(0);
			
			$stmt = $this->pdo->prepare("SELECT * FROM configuration WHERE user_Id=?");
			$stmt->execute([$userId]);
			
			//Configuration is existing
			if ($stmt->rowCount() > 0)
			{
				//Edit the configuration
				$stmt = $this->pdo->prepare("UPDATE configuration SET monthlyBudget=?, resetType=?, resetDate=? WHERE user_Id=?");
				$stmt->execute([floatval($monthlyBudget), $resetType, $resetDate, $userId]);
			}
			//Configuration is not existing yet
			else
			{
				//Create the configuration
				$stmt = $this->pdo->prepare("INSERT INTO configuration (user_Id, monthlyBudget, resetType, resetDate) VALUES (?, ?, ?, ?)");
				$stmt->execute([$userId, floatval($monthlyBudget), $resetType, $resetDate]);
			}
		}
		else
		{
			//error
		}		
	}
}
