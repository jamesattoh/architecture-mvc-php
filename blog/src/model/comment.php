<?php 
    // src/model/comment.php
    class Comment  //we create ou class comment
    {
        public string $author;                //we create the properties of an element of our class
        public string $frenchCreationDate;
        public string $comment;
    }

    function getComments(string $post): array //this function is used to get the comments from the database
    {
        $database = commentDbConnect();
        $statement = $database->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh/%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);

        $comments = [];

        while(($row = $statement->fetch())) { //a loop that continues until the $statement object's fetch() method returns a result line
            $comment = new Comment(); //we create a new instance $comment of class Comment 
            
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment =  $row['comment'];
            
            $comments[] = $comment; 
        }
        return $comments;
    }

    function createComment(string $post, string $author, string $comment) :bool
    {
        $database = commentDbConnect();
        $statement = $database->prepare(
            'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())' //we give to mysql the responsibility to fill the comment_date through the function NOW
        );
        $affectedLines = $statement->execute([$post, $author, $comment]);

        return($affectedLines > 0 ) ;
    }


    function commentDbConnect()
    {
        
        //we connect to the databse
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

        return $database;


    }