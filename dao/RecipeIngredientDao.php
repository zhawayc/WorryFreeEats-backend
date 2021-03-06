<?php

    require_once __DIR__ ."/ConnectionManager.php" ;

    class RecipeIngredientDao{
        private $connectionManager;
        static $recipeIngredientDao = null;

        public function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$recipeIngredientDao==null){
                self::$recipeIngredientDao = new RecipeIngredientDao();
            }
            return self::$recipeIngredientDao;
        }

        public function getIngredientIdsByRecipeId($recipeId){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT IngredientId FROM RecipeIngredient WHERE RecipeID='$recipeId';";
            $result=$conn->query($sql);
            $res = array();

            // IngredientId
            while($row=$result->fetch_assoc()){
                array_push($res, $row);
            }
            return $res;
        }

        public function getIngredientIdsByRecipeIdAndPage($recipeId, $count, $cursor){
            $startCursor = $cursor;
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT IngredientId FROM RecipeIngredient WHERE RecipeID='$recipeId' LIMIT $cursor, $count;";
            $result=$conn->query($sql);
            $res = array();

            // IngredientId
            while($row=$result->fetch_assoc()){
                array_push($res, ["node"=>$row, "cursor"=>$cursor]);
                $cursor++;
            }

            $pageInfo = [
                "hasNextPage"=>true,
                "hasPreviousPage"=>($cursor>$count),
                "startCursor"=>$startCursor,
                "endCursor"=>$cursor
            ];

            return ["pageInfo"=>$pageInfo, "edges"=>$res];
        }
    }