<?php 
    class DatabaseConnection 
    {
        public ?PDO $database = null;

        public function getConnection(): PDO
        {
            if ($this->database === null) {
                //we connect to the database
                $this->database = new PDO ('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            }
            return $this->database;
        }
    }