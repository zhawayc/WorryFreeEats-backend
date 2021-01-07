<?php

    require_once __DIR__."/ConnectionManager.php";

    class UserDao{
        private $connectionManager;
        static $userDao=null;

        private function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$userDao==null){
                self::$userDao=new UserDao();
            }
            return self::$userDao;
        }

        public function getUserByUserId($userId){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM User WHERE UserId = '$userId';";
            $result = $conn->query($sql);
            return $result->fetch_assoc();
        }

        public function userLogin($args){
            $userName = $args["UserName"];
            $userPass = $args["UserPass"];
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM User WHERE UserName = '$userName' AND UserPass = '$userPass'";
            $result = $conn->query($sql);
            return $result->fetch_assoc();
        }

        public function getUserByUserName($name){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM User WHERE UserName = '$name';";
            $result = $conn->query($sql);
            return $result->fetch_assoc();
        }

        public function insertUser($user){
            $userName = $user["UserName"];
            $userPass = $user["UserPass"];
            $firstName = $user["FirstName"];
            $email = $user["Email"];
            $conn = $this->connectionManager->getConnection();
            $sql = "INSERT INTO User(UserName, UserPass, FirstName, Email) 
            VALUES ('$userName','$userPass','$firstName','$email');";
            $conn->query($sql);
            $user["UserId"] = mysqli_insert_id($conn);
            return $user;
        }
    }