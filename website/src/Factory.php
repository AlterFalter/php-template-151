<?php 

namespace AlterFalter;

// constructs controllers, pdo and services 
class Factory
{
	private $config;

	// Constructor
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	// Methods
	public static function createFromIniFile($filename)
	{
		return new Factory(
				parse_ini_file($filename, true)
			);
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function getPDO() 
	{
		return new \PDO(
				"mysql:host=mariadb;dbname=ZeusDb;charset=utf8",
				$this->config["database"]["user"],
				"my-secret-pw",
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			);
	}

	public function getBasicPdo()
	{
		return new BasicPdo(
			getPDO()
		);
	}
	
	public function getIndexController()
	{
		return new Controller\IndexController(
				$this->getTemplateEngine()
			);
	}
	
	
	public function getLoginPdoService() 
	{
		return new Service\Login\LoginPdoService(
				$this->getPDO()
			);
	}
	
	public function getLoginController()
	{
		return new Controller\LoginController(
				$this->getTemplateEngine(),
				$this->getLoginPdoService(),
				$this->getMailController(),
				$this->getIndexController(),
				$this->getSystemController(),
				$this->getErrorController()
			);
	}
	
	public function getDrivePdoService()
	{
		return new Service\Drive\DrivePdoService(
			$this->getPDO()
		);
	}
	
	public function getDriveController()
	{
		return new Controller\DriveController(
				$this->getTemplateEngine(),
				$this->getDrivePdoService(),
				$this->getErrorController(),
				$this->getLoginController(),
				$this->getSystemController()
			);
	}

	public function getMailController()
	{
		return new Controller\MailController(
				$this->getBasicMailer()
			);
	}

	public function getErrorController()
	{
		return new Controller\ErrorController(
				$this->getTemplateEngine()
			);
	}

	public function getSystemController()
	{
		return new Controller\SystemController();
	}

	private function getBasicMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
				->setUsername("gibz.module.151@gmail.com")
				->setPassword("Pe$6A+aprunu")
			);
	}
}
