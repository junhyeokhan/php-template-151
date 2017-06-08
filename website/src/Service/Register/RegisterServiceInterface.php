<?php

namespace junhyeokhan\Service\Register;

interface RegisterServiceInterface
{
	public function register($username, $password, $firstName, $lastName,  $gender, $dateOfBirth);
}