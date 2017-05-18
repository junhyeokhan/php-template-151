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
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? AND password=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $password);
		$stmt->execute();
		
		
		
		if($stmt->rowCount() == 1)
		{
			$_SESSION["email"] = $data["email"];
			return true;
		}
		else
		{
			return false;
		}
	}
}
