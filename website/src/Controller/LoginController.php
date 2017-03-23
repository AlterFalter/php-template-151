<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;

class LoginController 
{
  /**
   * @var AlterFalter\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $pdo;
  
  /**
   * @param AlterFalter\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, \PDO $pdo)
  {
     $this->template = $template;
     $this->pdo = $pdo;
  }

  public function showLogin(){
  	echo $this->template->render("login.html.php");
  }
  
  public function login(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data)) {
  		$this->showLogin();
  		return;
  	}
  	
  	$statement = $this->pdo->prepare("SELECT * FROM user WHERE email=? AND password=?");
  	$statement->bindValue(1, $data["email"]);
  	$statement->bindValue(2, $data["password"]);
  	$statement->execute();
  	
  	if ($statement->rowCount() == 1){
  		$_SESSION["email"] = $data["email"];
  		header["Location: /"];
  	}
  	else{
  		echo $this->template->render("login.html.php", [
  				"email" => $data["email"]
  				
  		]);
  	}
  }
}
