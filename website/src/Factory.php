<?php

namespace junhyeokhan;

class Factory {
	private $config;
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	public function getIndexController()
	{
		return new Controller\IndexController(
			$this->getTemplateEngine()		
		);
	}
	
	public function getLoginController()
	{
		return new Controller\LoginController(
			$this->getTemplateEngine(),
			$this->getLoginService()
		);
	}

	public function getRegisterController()
	{
		return new Controller\RegisterController(
				$this->getTemplateEngine(),
				$this->getRegisterService()
				);
	}
	
	public function getConfigurationController()
	{
		return new Controller\ConfigurationController(
				$this->getTemplateEngine(), 
				$this->getConfigurationService());
	}
	
	public function getBudgetController()
	{
		return new Controller\BudgetController(
				$this->getTemplateEngine(),
				$this->getBudgetService());
	}
	
	public function getStatisticsController()
	{
		return new Controller\StatisticsController(
				$this->getTemplateEngine(),
				$this->getConfigurationService(),
				$this->getBudgetService());
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
			\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
			->setUsername("gibz.module.151@gmail.com")
			->setPassword("Pe$6A+aprunu")
		);
	}
	
	public function getPdo()
	{
		return new \PDO(
			"mysql:host=" . $this->config["database"]["host"] . ";dbname=app;charset=utf8",
			$this->config["database"]["user"],
			$this->config["database"]["password"],
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		);
	}
	
	public function getLoginService()
	{
		return new Service\Login\LoginPdoService(
			$this->getPdo(),
			$this->getMailer()
		);
	}
	
	public function getRegisterService()
	{
		return new Service\Register\RegisterPdoService(
			$this->getPdo()		
		);
	}
	
	public function getConfigurationService()
	{
		return new Service\Configuration\ConfigurationPdoService(
			$this->getPdo()
		);
	}
	
	public function getBudgetService()
	{
		return new Service\Budget\BudgetPdoService($this->getPdo());
	}
}