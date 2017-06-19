<?php

namespace junhyeokhan\Service\Register;

class RegisterPdoService implements RegisterServiceInterface
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function register($email, $password, $firstName, $lastName, $gender, $dateOfBirth)
	{
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$query->execute([$email]);

		// Email is already existing
		if ($query->rowCount() > 0)
		{
			$_SESSION["register"]["error"] = "A user with entered email is already existing!";
			return false;
		}
		else
		{
			$query = $this->pdo->prepare("INSERT INTO person (FirstName, LastName, Gender, DateOfBirth) VALUES (?, ?, ?, ?)");
			$query->execute([$firstName, $lastName, $gender, $dateOfBirth]);
			
			$personId = $this->pdo->lastInsertId();
			
			$query = $this->pdo->prepare("INSERT INTO user (email, password, person_Id) VALUES (?, ?, ?)");

			$hash = password_hash($password, PASSWORD_DEFAULT);
			
			$query->execute([$email, $hash, $personId]);			
			
			return $query->rowCount() == 1;			
		}
	}
}
