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
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	/*public function getMailer()
	{
		return \Swift_Mailer::newInstance(
			\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
			->setUsername("gibz.module.151@gmail.com")
			->setPassword("Pe$6A+aprunu")
		);
	}*/
	
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
		return new Service\LoginMysqlService(
			$this->getPdo()		
		);
	}
}