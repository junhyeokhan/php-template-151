<?php

namespace junhyeokhan\Service\Login;

class LoginPdoService implements LoginServiceInterface
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
	
	public function authenticate($email, $password)
	{		
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		
		$isPasswordTrue = false;
		
		if ($stmt->rowCount() >= 1)
		{
			$userData = $stmt->fetchAll();
			
			$personId = $userData[0]['person_Id'];
			$hash = $userData[0]['password'];
			$isPasswordTrue = password_verify($password, $hash);
		}
		if($isPasswordTrue)
		{			
			$stmt = $this->pdo->prepare("SELECT * FROM person WHERE Id=?");
			$stmt->execute([$personId]);
			
			$personalData = $stmt->fetchAll();
			
			$gender = $personalData[0]['Gender'];
			$firstName = $personalData[0]['FirstName'];
			$lastName = $personalData[0]['LastName'];
			
			$_SESSION["user"]["email"] = $email;			
			$_SESSION["user"]["firstName"] = $firstName;
			$_SESSION["user"]["lastName"] = $lastName;
			$_SESSION["user"]["gender"] = $gender;
			
			return true;
		}
		else
		{		
			return false;
		}
	}
}
