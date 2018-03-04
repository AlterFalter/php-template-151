<?php

namespace AlterFalter\Controller;

use AlterFalter\SimpleTemplateEngine;

class ErrorController 
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

  public function error($errorCode, $errorMessage)
  {
    // logger habe ich entfernt da er noch ein kleines problem hatte und ich mich zuerst mal auf den Hauptteil beschränken wollte
    //$this->LogError($errorCode, $errorMessage);
    echo $this->template->renderView("error.html.php", [
      "errorCode" => $errorCode,
      "errorMessage" => $errorMessage
    ]);
  }

  public function apiError($errorCode, $errorMessage)
  {
    //$this->LogError($errorCode, $errorMessage);
    echo "We don't have an API!";
  }

  private function logError($errorCode, $errorMessage)
  {
    
  }
}
