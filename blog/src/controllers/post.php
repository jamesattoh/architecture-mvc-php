<?php
	namespace Application\Controllers\Post;

	require_once('src/lib/database.php');
	require_once('src/model/post.php'); //require_once is to include no more than one model.php as it's also a library code. If not, php will crash
	require_once('src/model/comment.php');

	use Application\Model\Post\PostRepository; 
	use Application\Model\Comment\CommentRepository; 
	use Application\Lib\Database\DatabaseConnection;

	class Post 
	{
		public function execute(string $identifier)
		{	
			$connection = new DatabaseConnection();
	
			$postRepository = new PostRepository(); //in order to use something in a controller, it must be created or its type must be eextracted or specified
			$postRepository->connection = $connection; //to initialize the connection property with a new instance of DatabaseConnection
			$post = $postRepository->getPost($identifier);
	
			$commentRepository = new CommentRepository();
			$commentRepository->connection = $connection;
			$comments = $commentRepository->getComments($identifier);
	
			require('templates/post.php');
		}
	}