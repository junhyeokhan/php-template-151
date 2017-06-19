<?php

namespace junhyeokhan\Service\Configuration;

interface ConfigurationServiceInterface
{
	public function getConfiguration($email);
	public function saveConfiguration($email, $monthlyBudget, $resetType, $resetDate);
}