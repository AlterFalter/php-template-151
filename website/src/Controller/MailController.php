<?php

namespace AlterFalter\Controller;

use Swift_Message;

class MailController 
{
	private $basicMailer;
	
	// constructor
	public function __construct($basicMailer)
	{
		$this->basicMailer = $basicMailer;
	}

	public function sendMail($to, $subject, $message)
	{
		$this->basicMailer->send(
			Swift_Message::newInstance($subject)
		   	->setFrom(["gibz.module.151@gmail.com" => "ZeusDrive"])
			->setTo([$to => "Client"])
			->setBody($message, "text/html")
		);
	}
}