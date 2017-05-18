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
	
	public function register($username, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$stmt->bindValue(1, $username);

		//Is email already existing?
		if ($stml->rowCount() > 0)
		{
			$_SESSION["register"]["error"] = "A user with entered email is already existing!";
		}
		else
		{
			$stmt = $this->pdo->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
			$stmt->bindValue(1, $username);
			$hash = password_hash($password, PASSWORD_DEFAULT);
			//password_verify($password, $hash);
			$stmt->bindValue(2, $hash);
			$stmt->execute();
		
		if($stmt->rowCount() == 1)
		{
			$_SESSION["email"] = $username;
			return true;
		}
		else
		{
			return false;
		}
			
		}
		
		
	}
}
