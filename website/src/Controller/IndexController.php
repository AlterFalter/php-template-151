<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;

class IndexController 
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

  public function homepage() {
    echo "INDEX";
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => $name]);
  }
}
