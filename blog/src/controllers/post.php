<?php
// controllers/post.php

require_once('src/model/post.php'); //require_once is to include no more than one model.php as it's also a library code. If not, php will crash

require_once('src/model/comment.php');

function post(string $identifier)
{
	$post = getPost($identifier);
	$comments = getComments($identifier);

	require('templates/post.php');
}