<?php 
    namespace Application\Model\Comment;

    require_once('src/lib/database.php');
    
    use Application\Lib\Database\DatabaseConnection; 

    class Comment  //we create ou class comment
    {   
        public string $identifier;
        public string $author;                //we create the properties of an element of our class
        public string $frenchCreationDate;
        public string $comment;
        public string $post;
    }

    class CommentRepository
    {
        public DatabaseConnection $connection; //explanation in /model/post.php at same place

        public function getComments(string $post): array //this function is used to get the comments from the database
        {
            $statement = $this->connection->getConnection()->prepare(
                "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh/%imin%ss') AS french_creation_date, post_id FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
            );
            $statement->execute([$post]);
    
            $comments = [];
    
            while(($row = $statement->fetch())) { //a loop that continues until the $statement object's fetch() method returns a result line
                $comment = new Comment(); //we create a new instance $comment of class Comment 
                $comment->identifier = $row['id'];
                $comment->author = $row['author'];
                $comment->frenchCreationDate = $row['french_creation_date'];
                $comment->comment =  $row['comment'];
                $comment->post = $row['post_id'];

                $comments[] = $comment; 
            }
            return $comments;
        }


        public function getComment(string $identifier): ?Comment //the return type can be Comment or null
        {
            $statement = $this->connection->getConnection()->prepare(
                "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh/%imin%ss') AS french_creation_date, post_id FROM comments WHERE id = ?"
            );
            $statement->execute([$identifier]);

            $row = $statement->fetch(); //we retrieve the results of our sql request in the variable $row

            if($row == false){
                return null;
            }

            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment = $row['comment'];
            $comment->post = $row['post_id'];

            return $comment;
        }


        public function createComment(string $post, string $author, string $comment): bool
        {
            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())' //we give to mysql the responsibility to fill the comment_date through the function NOW
            );
            $affectedLines = $statement->execute([$post, $author, $comment]);
    
            return($affectedLines > 0 ) ;
        }

        public function updateComment(string $identifier, string $author, string $comment): bool
        {
            $statement = $this->connection->getConnection()->prepare(
                'UPDATE comments SET author = ?, comment = ? WHERE id = ?'
            );

            $affectedLines = $statement->execute([$author, $comment, $identifier]);

            return $affectedLines;
        }        
    }