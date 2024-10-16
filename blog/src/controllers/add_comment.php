<?php
    // src/controllers/add_comment.php
    require_once('src/model/comment.php');
    function addComment( string $post, array $input) 
    {
        $author = null;
        $comment = null;

        if(!empty($input['author']) && !empty($input['comment'])) 
        {
            $author = $input['author'];
            $comment = $input['comment'];
        } else {
            die('les données du formulaires sont erronnées');
        }

        $success = createComment($post, $author, $comment);

        if(!$success) {
            die('Impossible d\'ajouter le commentaire');
        } else {
            header('Location:index.php?action=post&id=' . $post); //we redirect the user on the page where the post, we add the comment, is
        }
    }
