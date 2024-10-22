<?php
    namespace Application\Model\Post;

    require_once('src/lib/database.php');

    use Application\Lib\Database\DatabaseConnection;
    
    class Post 
    {
        public string $title;
        public string $content;
        public string $frenchCreationDate;
        public string $identifier;
    }

    class PostRepository  //we create a new class PostRepository which has a nullable PDO property named database
    {
        
        public DatabaseConnection $connection;  //preparing to use the POO : $connection could contain the object "$database" which we'll use below through the property connection

        public function getPost(string $identifier): Post { //This function will return an element of type Post

           //$this represent the current object on which the method is called {$object->method();}; so as we create 3 objects as each one will correspond to the object on which the method is called 
           //every function in a class automatically receives the variable $this which contain

            $statement = $this->connection->getConnection()->prepare( //we ask connection to provide us the connection by getConnection(); this is the POO : we use the object "$database" as a property "connection" in a foreign class "PostRepository"
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
                
            // we retrieve the 5 last blog posts
                $statement = $this->connection->getConnection()->query( //the return of a query is usually contained in a statement variable
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
    }