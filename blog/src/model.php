<?php
    function getPosts() {
        
    //we connect to the databse
    try {
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
    } catch(Exception $e) {
    die( 'Erreur : '.$e->getMessage());
    }

    // we retrieve the 5 last blog posts
        $statement = $database->query( //le retour d'une query est habituellement contenu dans la variable statement
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
    );

    $posts = [];

    while($row = $statement ->fetch()) {
        $post = [
            'title' => $row['title'],
            'content' => $row['content'],
            'french_creation_date' => $row['french_creation_date'],
        ];   

        $posts[] = $post;
    }
    return $posts;
    }
