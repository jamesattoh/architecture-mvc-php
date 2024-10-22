<?php
	namespace Application\Controllers\Homepage;

	require_once('src/lib/database.php');
	require_once('src/model/post.php'); //require_once is to include no more than one model.php as it's also a library code. If not, php will crash

	use Application\Model\Post\PostRepository;
	use Application\Lib\Database\DatabaseConnection;

	class Homepage
	{
		public function execute() {

			$postRepository = new PostRepository();
			$postRepository->connection = new DatabaseConnection(); //to initialize the connection property with a new instance of DatabaseConnection
			$posts = $postRepository->getPosts();
	
			require_once('templates/homepage.php');
		}
	}