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

  public function home()
  {
    echo $this->template->renderView("home.html.php");
  }

  public function aboutus()
  {
    echo $this->template->renderView("aboutus.html.php");
  }

  public function notFound()
  {
    echo $this->template->renderView("notfound.html.php");
  }
}
