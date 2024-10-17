<?php
// controllers/homepage.php
require_once('src/model/post.php'); //require_once is to include no more than one model.php as it's also a library code. If not, php will crash

function homepage() {

	$postRepository = new PostRepository();

	$posts = $postRepository->getPosts();

	require_once('templates/homepage.php');
}