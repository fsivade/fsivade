<?php
namespace Library;

class Page extends ApplicationComponent
{
  protected $contentFile;
  protected $vars = array();
  
  public function addVar($var, $value)
  {
    if (!is_string($var) || is_numeric($var) || empty($var))
    {
      throw new \InvalidArgumentException('Le nom de la variable doit �tre une chaine de caract�re non nulle');
    }
    
    $this->vars[$var] = $value;
  }
  
  public function getGeneratedPage()
  {
    if (!file_exists($this->contentFile))
    {
      throw new \RuntimeException('La vue sp�cifi�e n\'existe pas');
    }
	
	$user = $this->app->user();
    
    extract($this->vars);
    
    ob_start();
    require $this->contentFile;
    $content = ob_get_clean();
    
    ob_start();
    require dirname(__FILE__).'/../Applications/'.$this->app->name().'/Templates/layout.php';
    return ob_get_clean();
  }
  
  public function setContentFile($contentFile)
  {
    if (!is_string($contentFile) || empty($contentFile))
    {
      throw new \InvalidArgumentException('La vue sp�cifi�e est invalide');
    }
    
    $this->contentFile = $contentFile;
  }
}