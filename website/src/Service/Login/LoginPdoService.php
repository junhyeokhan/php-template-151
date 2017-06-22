<?php

namespace junhyeokhan\Service\Login;

class LoginPdoService implements LoginServiceInterface
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function authenticate($email, $password)
	{
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$query->execute ([$email]);
		
		$isPasswordTrue = false;
		
		if ($query->rowCount () >= 1) 
		{
			$userData = $query->fetchAll()[0];
			$personId = $userData['person_Id'];
			$hash = $userData['password'];
			$isPasswordTrue = password_verify($password,$hash);
			
			if ($isPasswordTrue)
			{
				$query = $this->pdo->prepare("SELECT * FROM person WHERE Id=?");
				$query->execute ([$personId]);
					
				$personalData = $query->fetchAll()[0];
				
				$gender = $personalData["Gender"];
				$firstName = $personalData["FirstName"];
				$lastName = $personalData["LastName"];
					
				$_SESSION["user"]["email"] = $email;
				$_SESSION["user"]["firstName"] = $firstName;
				$_SESSION["user"]["lastName"] = $lastName;
				$_SESSION["user"]["gender"] = $gender;
				
				return true;
			}
			else
			{
				$_SESSION["login"]["error"] = "Wrong password!";
				return false;
			}
		}
		else
		{
			$_SESSION["login"]["error"] = "No account with entered email is found!";
			return false;
		}
	}
}
