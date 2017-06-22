<?php

namespace junhyeokhan\Service\Account;

interface AccountServiceInterface
{	
	public function deleteAccount($email, $password);
}