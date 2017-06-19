<?php

namespace junhyeokhan\Service\Password;

class PasswordPdoService implements PasswordServiceInterface
{
	private $pdo;
	private $mailer;
	
	public function __construct(\PDO $pdo, \Swift_Mailer $mailer)
	{
		$this->pdo = $pdo;
		$this->mailer = $mailer;
	}
	
	public function sendResetEmail($email)
	{
		$timePoint = time();
		
		$query = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
		$query->execute([$email]);
		
		if ($query->rowCount() > 0)
		{
			$userId = $query->fetchColumn(0);
			
			$key = sprintf('%d%d', $userId, $timePoint);
			
			$url = sprintf ("%s://%s/%s?key=%s", isset($_SERVER ['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST'], "resetpassword", $key);
			
			$message = (new \Swift_Message())
				->setSubject('[BudgetKnight] Reset password')
				->setFrom(['junhyeokhan.it@gmail.com' => 'Junhyeok Han'])
				->setTo([$email])
				->setBody("You can reset your password here. Please click on the link or copy the url to move to the page. $url"
			);
			
			$this->mailer->send($message);
			
			$query = $this->pdo->prepare("UPDATE user SET resetPoint = ? WHERE Id = ?");
			$query->execute([$timePoint, $userId]);
		}
	}
	
	public function getEmailByResetKey($key)
	{
		$query = $this->pdo->prepare("SELECT * from user WHERE  Concat(Id, resetPoint) = ?");
		$query->execute([$key]);
		
		if ($query->rowCount () > 0)
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
		
		if ($stmt->rowCount()> 0)
		{
			$stmt = $this->pdo->prepare("UPDATE user SET password = ?, resetPoint = ? WHERE email = ?");
			
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$stmt->execute([$hash, null, $email]);
			
			return $stmt->rowCount () == 1;
		}
		else
		{
			return false;
		}
	}
}