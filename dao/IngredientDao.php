<?php
    require_once(__DIR__."/ConnectionManager.php");
    
    class IngredientDao{
        private $connectionManager;
        static $ingredientDao = null;

        public function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$ingredientDao==null){
                self::$ingredientDao = new IngredientDao();
            }
            return self::$ingredientDao;
        }

        public function getIngredientByIngredientId($ingredientId){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM Ingredient WHERE IngredientID='$ingredientId';";
            $result = $conn->query($sql);
            return $result->fetch_assoc();
        }
    }
?>