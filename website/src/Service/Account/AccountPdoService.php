<?php

namespace junhyeokhan\Service\Account;

class AccountPdoService implements AccountServiceInterface
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function deleteAccount($email, $password)
	{
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$query->execute ([$email]);
		
		$isPasswordTrue = false;
		
		if ($query->rowCount () >= 1) 
		{	

			$userData = $query->fetchAll()[0];
			$userId = $userData['Id'];
			$personId = $userData['person_Id'];
			$hash = $userData['password'];
			$isPasswordTrue = password_verify($password,$hash);
			
			if ($isPasswordTrue)
			{
				try {
					$this->pdo->beginTransaction();

					// delete all entries
					$query = $this->pdo->prepare("DELETE FROM entry WHERE user_Id=?");
					$query->execute ([$userId]);
					
					// delete the configuration
					$query = $this->pdo->prepare("DELETE FROM configuration WHERE user_Id=?");
					$query->execute ([$userId]);

					// delete the user
					$query = $this->pdo->prepare("DELETE FROM user WHERE Id=?");
					$query->execute ([$userId]);
					
					// delete the person
					$query = $this->pdo->prepare("DELETE FROM person WHERE Id=?");
					$query->execute ([$personId]);
					
					$this->pdo->commit();
					return true;
				}
				catch (\PDOException $e)
				{
					$this->pdo->rollback();
					$_SESSION["deleteaccount"]["error"] = "Something went wrong with database transaction! Please try again!".$e;
					return false;
				}
			}
			else
			{
				$_SESSION["deleteaccount"]["error"] = "Wrong password!";
				return false;
			}
		}
		else
		{
			$_SESSION["deleteaccount"]["error"] = "No account with enetered email is found!";
			return false;
		}
	}
}
