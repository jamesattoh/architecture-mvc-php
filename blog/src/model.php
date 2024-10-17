<?php


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