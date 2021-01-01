<?php
    require_once __DIR__."/ConnectionManager.php";

    class ReviewDao{
        private $connectionManager;
        static $reviewDao;

        private function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$reviewDao==null){
                self::$reviewDao=new ReviewDao();
            }
            return self::$reviewDao;
        }

        public function getReviewByRecipeId($id){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM Review WHERE RecipeId = '$id';";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
                array_push($res, $row);
            }
            return $res;
        }

        public function insertReview($recipe){
            $reviewText = $recipe["ReviewText"];
            $recipeId = $recipe["RecipeID"];
            $rating = $recipe["Rating"];
            $userId = $recipe["UserId"];
            $conn = $this->connectionManager->getConnection();
            $sql = "INSERT INTO Review(ReviewText, RecipeID, Rating, UserId) 
            VALUES('$reviewText','$recipeId','$rating','$userId');";
            $conn->query($sql);
            $recipe["ReviewId"] = mysqli_insert_id($conn);
        
            return $recipe;
        }

        public function updateReview($recipe){
            $reviewId = $recipe["ReviewId"];
            $reviewText = $recipe["ReviewText"];
            $rating = $recipe["Rating"];
            $conn = $this->connectionManager->getConnection();
            $sql = "UPDATE Review SET ReviewText = '$reviewText', Rating = '$rating' 
            WHERE ReviewId = '$reviewId'";
            $conn->query($sql);
            return $recipe;
        }

        public function deleteReview($id){
            $conn = $this->connectionManager->getConnection();
            $sql = "DELETE FROM Review WHERE ReviewId = '$id'";
            $conn->query($sql);
            return $id;
        }
    }