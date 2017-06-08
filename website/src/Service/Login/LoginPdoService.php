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
			$hash = $stmt->fetchColumn(3);
			$isPasswordTrue = password_verify($password, $hash);
			
			$personId = $stmt->fetchColumn(1);
		}
		
		if($isPasswordTrue)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM person WHERE Id=?");
			$stmt->execute([$personId]);
			
			$gender = $stmt->fetchAll();
			$lastName = $stmt->fetchColumn(3);
			
			echo $gender;
			echo $lastName;
			die();
			
			$_SESSION["user"]["email"] = $email;			
			$_SESSION["user"]["name"] = $lastName;
			$_SESSION["user"]["gender"] = $gender;
			
			return true;
		}
		else
		{
			return false;
		}
	}
}
