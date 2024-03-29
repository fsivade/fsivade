<?php
namespace Applications\Frontend\Modules\News;

class NewsController extends \Library\BackController
{
  public function executeIndex(\Library\HTTPRequest $request)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
    
    // On ajoute une d�finition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreNews.' derni�res news');
    
    // On r�cup�re le manager des news.
    $manager = $this->managers->getManagerOf('News');
    
    // Cette ligne, vous ne pouviez pas la deviner sachant qu'on n'a pas encore touch� au mod�le.
    // Contentez-vous donc d'�crire cette instruction, nous impl�menterons la m�thode ensuite.
    $listeNews = $manager->getList(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContenu($debut);
      }
    }
    
    // On ajoute la variable $listeNews � la vue.
    $this->page->addVar('listeNews', $listeNews);
  }
  
  public function executeShow(\Library\HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
    
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }
  
  public function executeInsertComment(\Library\HTTPRequest $request)
  {
    $this->page->addVar('title', 'Ajout d\'un commentaire');
    
    if ($request->postExists('pseudo'))
    {
      $comment = new \Library\Entities\Comment(array(
        'news' => $request->getData('news'),
        'auteur' => $request->postData('pseudo'),
        'contenu' => $request->postData('contenu')
      ));
      
      if ($comment->isValid())
      {
        $this->managers->getManagerOf('Comments')->save($comment);
        
        $this->app->user()->setFlash('Le commentaire a bien �t� ajout�, merci !');
        
        $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
      }
      else
      {
        $this->page->addVar('erreurs', $comment->erreurs());
      }
      
      $this->page->addVar('comment', $comment);
    }
  }
  
}