<?php

namespace Application\Controllers\UpdateComment;

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;


class UpdateComment
{
    public function execute(string $identifier, ?array $input)
    {
        //if we have an input, we do this for submission
        if($input !== null) {
            $author = null;
            $comment = null;

            if (!empty($input['author']) && !empty($input['comment'])) {
                $author = $input['author'];
                $comment = $input['comment'];
            } else {
                throw new \Exception ('les données du formulaire sont invalides');
            }

            $commentRepository = new CommentRepository();
            $commentRepository->connection = new DatabaseConnection();
            $success = $commentRepository->updateComment($identifier, $author, $comment); //we use our function defined in the src/controllers/update
            
            if (!$success) {
                throw new \Exception('Impossible de modifier le commentaire !');
            } else {
                header('Location: index.php?action=updateComment&id=' . $identifier); //if the updating didn't worked, then redirect to the rooter
            }
        }

        //else we display the form
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $comment = $commentRepository->getComment($identifier);

        if($comment === null){
            throw new \Exception("Le commentaire $identifier n'existe pas.");  
        }

        require('templates/update_comment.php');
    }
}