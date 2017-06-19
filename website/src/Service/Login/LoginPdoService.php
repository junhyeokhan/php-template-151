<?php

namespace junhyeokhan\Service\Login;

class LoginPdoService implements LoginServiceInterface
{
	/**
	 * @var \PDO
	 */
	private $pdo;
	private $mailer;
	
	/**
	 * @param \PDO
	 */
	public function __construct(\PDO $pdo, \Swift_Mailer $mailer)
	{
		$this->pdo = $pdo;
		$this->mailer = $mailer;
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
	
	public function sendResetEmail($email)
	{		
		$timePoint = time();
		
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$query->execute([$email]);
		
		if ($query->rowCount() > 0)
		{
			$userId = $query->fetchColumn(0);
			$email = $query->fetchColumn(3);
			$password = $query->fetchColumn(4);
			
			$key = sprintf('%d%d', $userId, $timePoint);
			
			$message = (new \Swift_Message())
				->setSubject('[BudgetKnight] Reset password')
				->setFrom(['junhyeokhan.it@gmail.com' => 'Junhyeok Han'])
				->setTo([$email])
				->setBody('You can reset your password here. Please click on the link or copy the url to move to the page. ');

			$result = $this->mailer->send($message);
			
			//if result true
			$query = $this->pdo->prepare("UPDATE user SET resetPoint = ? WHERE Id = ?");
			$query->execute([$key, $userId]);
		}
	}
	
	public function getEmailByResetKey($key)
	{		
		
		$query = $this->pdo->prepare("SELECT * from user WHERE  Concat(Id, resetPoint) = ?");
		$query->execute([$key]);
	
		
		if ($query->rowCount() > 0)
		{	
			$email = $query->fetchColumn(3);
			return $email;
		}
		else
		{
			return "";
		}
	}
	
	public function updatePassword($email, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$stmt->execute([$email]);
		
		//Is user account found?
		if ($stmt->rowCount() > 0)
		{						
			$stmt = $this->pdo->prepare("UPDATE user SET password = ?, resetPoint = ? WHERE email = ?");

			$hash = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt->execute([$hash, null, $email]);	
			
			return $stmt->rowCount() == 1;		
		}
		else
		{
			return false;
		}		
	}
}
