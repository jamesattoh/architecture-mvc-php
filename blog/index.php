<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/add_comment.php');

use Application\Controllers\AddComment\AddComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;

try 
{
	if (isset($_GET['action']) && $_GET['action'] !== '') {
		if ($_GET['action'] === 'post') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$identifier = $_GET['id'];
	
				(new Post())->execute($identifier);
			} else {
				throw new Exception('Erreur : aucun identifiant de billet envoyé'); //throw new exception leads directly to the bloc catch
			}
		}elseif ($_GET['action'] === 'addComment') {
			if (isset($_GET['id']) && $_GET['id']>0) {
				$identifier = $_GET['id'];
	
				(new AddComment())->execute($identifier, $_POST); //in php we can retrieve the form data in the superglobal $_POST
			} else {
				throw new Exception("Erreur: Aucun identifiant de billet envoyé");
			}
		} else {
	
			throw new Exception("Erreur 404 : la page que vous recherchez n'existe pas."); //we use throw new Exception instead of echo die to let the catch part of try-catch retrieve the error message
		}
	} else {
		(new Homepage())->execute();
	}

} catch (Exception $e) { // if there is an error then ... 
	$errorMessage = $e->getMessage();
	
	require('templates/error.php');
}