<?php

namespace AlterFalter;

/**
 * Simple Template-Engine which provides arguments into a template,
 * captures the output and returns it to the caller.
 */
class SimpleTemplateEngine 
{
  /**
   * @var string Location of the directory containing the templates
   */
  private $templatePath;
  
  /**
   * @param string $templatePath 
   */
  public function __construct($templatePath) 
  {
    $this->templatePath = $templatePath;
  }
  
  /**
   * Renders a *.html.php file inside the template path.
   * @return string
   */
  public function renderPartialView($template, array $arguments = []) 
  {
    extract($arguments);
    ob_start();
    require($this->templatePath.$template);
    return ob_get_clean();
  }
  
  /**
   * Renders a *.html.php file inside the template path.
   * Adds layout site for the view.
   * @return string
   */
  public function renderView($template, array $arguments = [])
  {
  	extract($arguments);
  	ob_start();
    require($this->templatePath."layout/header.html.php");
  	require($this->templatePath."layout/menu.html.php");
  	require($this->templatePath.$template);
    require($this->templatePath."layout/footer.html.php");
  	return ob_get_clean();
  }
  
  /**
   * Renders a *.html.php file inside the template path.
   * Adds layout site for the view.
   * @return string
   */
  public function renderEditView($template, array $arguments = [])
  {
  	extract($arguments);
  	ob_start();
    require($this->templatePath."layout/header.html.php");
    require($this->templatePath."layout/edit/menu.html.php");
    require($this->templatePath.$template);
  	return ob_get_clean();
  }
}
