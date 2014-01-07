<?php
namespace Library\Models;

use \Library\Entities\Comment;

abstract class CommentsManager extends \Library\Manager
{
  /**
   * M�thode permettant d'ajouter un commentaire.
   * @param $comment Le commentaire � ajouter
   * @return void
   */
  abstract protected function add(Comment $comment);
  
  /**
   * M�thode permettant d'enregistrer un commentaire.
   * @param $comment Le commentaire � enregistrer
   * @return void
   */
  public function save(Comment $comment)
  {
    if ($comment->isValid())
    {
      $comment->isNew() ? $this->add($comment) : $this->modify($comment);
    }
    else
    {
      throw new \RuntimeException('Le commentaire doit �tre valid� pour �tre enregistr�');
    }
  }
  
  /**
   * M�thode permettant de r�cup�rer une liste de commentaires.
   * @param $news La news sur laquelle on veut r�cup�rer les commentaires
   * @return array
   */
  abstract public function getListOf($news);
}