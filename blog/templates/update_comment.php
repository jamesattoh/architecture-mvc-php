<?php $title = "Le Blod de l'AVBN ";?>

<?php ob_start();?>
<h1>Le super Blog de L'AVBN</h1>
<p><a href="index.php?action=post&id= <?= $comment->post ?>">Retourner au billet</a></p>

<h2>Modification du commentaire</h2>

<form action="index.php?action=updateComment&id=<?= $comment->identifier ?> " method="post">
    <div>
        <label for="author">Auteur</label>
        <input id="author" name="author" type="text" value="<?= htmlspecialchars($comment->author)?>">
    </div>

    <div>
        <label for="comment">Commentaire</label>
        <input id="comment" name="comment" type="text" value="<?= htmlspecialchars($comment->comment) ?>">
    </div>

    <div>
        <input type="submit" />
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>