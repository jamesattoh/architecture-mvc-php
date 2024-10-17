<?php

class Post 
{
    public string $title;
    public string $content;
    public string $frenchCreationDate;
    public int $identifier;
}

function getPosts() {
        
    $database = dbConnect();

    // we retrieve the 5 last blog posts
        $statement = $database->query( //the return of a query is usually contained in a statement variable
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
    );

    $posts = [];

    while($row = $statement ->fetch()) {
        $post = new Post();

        $post->title = $row['title'];
        $post->content = $row['content'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->identifier = $row['id'];
    

        $posts[] = $post;
    }
    return $posts;
    }