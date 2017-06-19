<?php

namespace junhyeokhan\Service\Register;

class RegisterPdoService implements RegisterServiceInterface
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
	
	public function register($email, $password, $firstName, $lastName,  $gender, $dateOfBirth)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$stmt->bindValue(1, $email);

		//Is email already existing?
		if ($stmt->rowCount() > 0)
		{
			$_SESSION["register"]["error"] = "A user with entered email is already existing!";
		}
		else
		{

			$stmt = $this->pdo->prepare("INSERT INTO person (FirstName, LastName, Gender, DateOfBirth) VALUES (?, ?, ?, ?)");
			$stmt->execute([$firstName, $lastName, $gender, $dateOfBirth]);
			
			$personId = $this->pdo->lastInsertId();
			
			$stmt = $this->pdo->prepare("INSERT INTO user (email, password, person_Id) VALUES (?, ?, ?)");

			$hash = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt->bindValue(1, $email);
			$stmt->bindValue(2, $hash);
			$stmt->bindValue(3, $personId);
			$stmt->execute();			
			
			return $stmt->rowCount() == 1;			
		}
		
		
	}
}
