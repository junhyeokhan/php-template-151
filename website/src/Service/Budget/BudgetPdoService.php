<?php

namespace junhyeokhan\Service\Budget;

class BudgetPdoService implements BudgetServiceInterface
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
	
	public function getBudget($email, $year, $month)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->execute([$email]);
		
		if ($stmt->rowCount() > 0)
		{
			$userId = $stmt->fetchColumn(0);
			
			$stmt = $this->pdo->prepare("SELECT * FROM configuration WHERE user_Id=?");
			$stmt->execute([$userId]);
				
			$data = $stmt->fetchAll()[0];
			
			$resetType = $data['resetType'];
			
			switch ($resetType)
			{
				case 'beginMonth' :
					$day = 1;
					break;
				case 'endMonth' :
					//TODO: What should I do here?
					break;
				case 'userDate' :
					$day = $data['resetDate'];
					break;
				default :
					break;
			}
			
			$stmt = $this->pdo->prepare("SELECT * FROM entry WHERE user_Id=? AND date >= '?' AND date < '?'");
			
			$stmt->execute([$userId, ])
		}
		else
		{
			//error message
		}
	}
}
