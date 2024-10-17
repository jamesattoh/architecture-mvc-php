<?php

class Post 
{
    public string $title;
    public string $content;
    public string $frenchCreationDate;
    public string $identifier;
}

class PostRepository 
{
    public ?PDO $database = null;

    public function getPost(string $identifier): Post { //This function will return an element of type Post
        $this->dbConnect();
        
        $statement = $this->database->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);
        
        $row = $statement->fetch();
        
        $post = new Post();
        
        $post->title = $row['title'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->content = $row['content'];
        $post->identifier = $row['id'];
    
        
        return $post;
    }

    public function getPosts(): array {
        
        $this->dbConnect();
    
        // we retrieve the 5 last blog posts
            $statement = $this->database->query( //the return of a query is usually contained in a statement variable
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

    public function dbConnect()
    {
        if ($this->database === null) {
            $this->database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        }
        //return $database;
    }
}