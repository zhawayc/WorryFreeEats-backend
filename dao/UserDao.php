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
    }