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
			
			$data = $stmt->fetchAll();
			if (count($data) > 0)
			{
				$resetType = $data[0]['resetType'];
					
				switch ($resetType)
				{
					case 'beginMonth' :
						$dateFrom = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), 1, date("Y")));
						$dateTo = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")+1, 1, date("Y")));
						break;
					case 'endMonth' :
						$dateFrom = date("Y-m-t", strtotime("-1 month"));
						$dateFrom = date("Y-m-t", strtotime());
						break;
					case 'userDate' :
						$day = $data['resetDate'];
						$dateFrom = mktime(0, 0, 0, date("m"), $day, date("Y"));
						$dateTo = mktime(0, 0, 0, date("m")+1, $day, date("Y"));
						break;
					default :
						break;
				}					
					
				$stmt = $this->pdo->prepare("SELECT * FROM entry INNER JOIN category ON entry.category_Id = category.category_Id WHERE user_Id=? AND date >= ? AND date < ? ORDER BY date");
				$stmt->execute([$userId, $dateFrom, $dateTo]);
				$entries = $stmt->fetchAll();
				
				return $entries;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			//error message
		}
	}
	
	public function getAllCategories()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM category");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function saveEntry($email, $date, $amountOfMoney, $description, $categoryId)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->execute([$email]);
		
		$user = $stmt->fetchAll();
		
		if (count($user) > 0)
		{
			$userId = $user[0]['Id'];
			
			$stmt = $this->pdo->prepare("INSERT INTO entry (category_Id, user_Id, amountOfMoney, description, date) VALUES (?, ?, ?, ?, ?)");
			$stmt->execute([$categoryId, $userId, $amountOfMoney, $description, $date]);
			return $stmt->rowCount() == 1;
		}
		else
		{
			return 0;
		}
	}
}
