<?php
    class Database{
        private $user = 'root';
        private $pass = '';
        private $dsn = 'mysql:host=localhost;dbname=zenor';
        public $conn;

        public function getConnection(){
            $this->conn = null;

            try{
                $this->conn = new PDO($this->dsn, $this->user, $this->pass);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>