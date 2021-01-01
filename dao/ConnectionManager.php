<?php
    class ConnectionManager{
        private $servername="localhost:3306";
        private $username="root";
        private $password="";
        private $database="WorryFree";
        private $conn;

        public function __construct(){
            $this->conn=new mysqli($this->servername, $this->username, 
            $this->password, $this->database);
        }

        public function getConnection(){
            return $this->conn;
        }
    }
?>