<?php

namespace junhyeokhan\Service\Password;

interface PasswordServiceInterface
{
	public function sendResetEmail($email);
	public function getEmailByResetKey($key);
	public function updatePassword($email, $password);
	
}