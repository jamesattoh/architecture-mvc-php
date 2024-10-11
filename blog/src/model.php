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
        "SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5"
    );

    $posts = [];

    while($row = $statement ->fetch()) {
        $post = [
            'title' => $row['titre'],
            'content' => $row['contenu'],
            'frenchCreationDate' => $row['date_creation_fr'],
        ];   

        $posts[] = $post;
    }
    return $posts;
    }
?>
