<?php
// controllers/post.php
require_once('src/lib/database.php');

require_once('src/model/post.php'); //require_once is to include no more than one model.php as it's also a library code. If not, php will crash

require_once('src/model/comment.php');

function post(string $identifier)
{
	$postRepository = new PostRepository(); //in order to use something in a controller, it must be created or its type must be eextracted pr specified
	$commentRepository = new CommentRepository();

	$postRepository->connection = new DatabaseConnection(); //to initialize the connection property with a new instance of DatabaseConnection

	$post = $postRepository->getPost($identifier);

	$commentRepository->connection = new DatabaseConnection();
	
	$comments = $commentRepository->getComments($identifier);

	require('templates/post.php');
}