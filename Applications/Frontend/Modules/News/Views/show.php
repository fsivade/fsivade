<p>Par <em><?php echo $news['auteur']; ?></em>, le <?php echo $news['dateAjout']->format('d/m/Y � H\hi'); ?></p>
<h2><?php echo $news['titre']; ?></h2>
<p><?php echo nl2br($news['contenu']); ?></p>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
  <p style="text-align: right;"><small><em>Modifi�e le <?php echo $news['dateModif']->format('d/m/Y � H\hi'); ?></em></small></p>
<?php } ?>

<p><a href="commenter-<?php echo $news['id']; ?>.html">Ajouter un commentaire</a></p>

<?php
if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore �t� post�. Soyez le premier � en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{
?>
  <fieldset>
    <legend>
      Post� par <strong><?php echo htmlspecialchars($comment['auteur']); ?></strong> le <?php echo $comment['date']->format('d/m/Y � H\hi'); ?>
    </legend>
    <p><?php echo nl2br(htmlspecialchars($comment['contenu'])); ?></p>
  </fieldset>
<?php
}
?>

<p><a href="commenter-<?php echo $news['id']; ?>.html">Ajouter un commentaire</a></p>