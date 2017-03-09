<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;

class LoginController 
{
  /**
   * @var AlterFalter\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param AlterFalter\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template)
  {
     $this->template = $template;
  }

  public function showLogin(){
  	echo $this->template->render("login.html.php");
  }
}
