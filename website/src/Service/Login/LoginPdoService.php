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
	
	public function authenticate($username, $password)
	{		
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		
		$isPasswordTrue = false;
		
		//Username is not existing
		if ($stmt->rowCount() >= 1)
		{
			$hash = $stmt->fetchColumn(2);
			$isPasswordTrue = password_verify($password, $hash);
		}
		
		if($isPasswordTrue)
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
