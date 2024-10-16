<?php
    function getPosts() {
        
    $database = dbConnect();

    // we retrieve the 5 last blog posts
        $statement = $database->query( //the return of a query is usually contained in a statement variable
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
    );

    $posts = [];

    while($row = $statement ->fetch()) {
        $post = [
            'title' => $row['title'],
            'content' => $row['content'],
            'french_creation_date' => $row['french_creation_date'],
            'identifier' => $row['id'],
        ];   

        $posts[] = $post;
    }
    return $posts;
    }

    function getPost($identifier) {
        $database = dbConnect();
     
        $statement = $database->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);
     
        $row = $statement->fetch();
        $post = [
            'title' => $row['title'],
            'french_creation_date' => $row['french_creation_date'],
            'content' => $row['content'],
            'identifier' => $row['id'],
        ];
     
        return $post;
    }
    
    

    function dbConnect() {
        //we connect to the databse
    try {
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        return $database;
    } catch(Exception $e) {
    die( 'Erreur : '.$e->getMessage());
    }
    }