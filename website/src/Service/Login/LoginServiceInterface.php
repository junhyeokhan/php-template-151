<?php

namespace junhyeokhan\Service\Login;

interface LoginServiceInterface
{
	public function authenticate($username, $password);
}