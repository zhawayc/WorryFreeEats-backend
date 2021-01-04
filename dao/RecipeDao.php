<?php

    require_once __DIR__."/ConnectionManager.php" ;

    class RecipeDao{
        private $connectionManager;
        static $recipeDao = null;

        public function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$recipeDao==null){
                self::$recipeDao = new RecipeDao();
            }
            return self::$recipeDao;
        }

        public function getRecipeById($recipeId){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * from Recipe WHERE RecipeID='$recipeId';";
            $result=$conn->query($sql);

            // RecipeName, ImageUrl
            return $result->fetch_assoc();
        }

        public function getRecipes(){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM Recipe LIMIT 10;";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
                array_push($res, $row);
            }
            return $res;
        }

        public function getRecipesByPage($count, $cursor){
            $startCursor = $cursor;
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM Recipe LIMIT $cursor, $count;";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
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

        public function getTop10Recipes(){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM Recipe INNER JOIN (
                SELECT RecipeID, AVG(Rating) AS AVG_Rating FROM Review
                GROUP BY RecipeID
                ORDER BY AVG_Rating DESC
                LIMIT 10
                ) AS T ON Recipe.RecipeID = T.RecipeID;";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
                array_push($res, $row);
            }
            return $res;
        }

        public function getTop10RecipesWithoutAllergy($allergy){
            $conn =$this->connectionManager->getConnection();
            $sql = "SELECT RecipeID, RecipeName, ImageUrl FROM Recipe INNER JOIN(
                SELECT Review.RecipeID AS Id FROM
                (SELECT RECIPE_WHOLE_SET.RecipeID AS RECIPE_ID_WITHOUT_MILK_ALLERGY FROM
                (SELECT RecipeID FROM Recipe) AS RECIPE_WHOLE_SET
                LEFT OUTER JOIN
                (SELECT RecipeIngredient.RecipeID AS Id FROM RecipeIngredient
                INNER JOIN Ingredient 
                ON RecipeIngredient.IngredientId=Ingredient.IngredientId
                INNER JOIN AllergyType ON Ingredient.AllergyTypeId=AllergyType.AllergyTypeId
                WHERE AllergyType.Allergy='$allergy'
                GROUP BY RecipeIngredient.RecipeID) AS RECIPE_WITH_MILK_ALLERGY
                ON RECIPE_WHOLE_SET.RecipeID = RECIPE_WITH_MILK_ALLERGY.ID
                WHERE RECIPE_WITH_MILK_ALLERGY.ID IS NULL) AS RECIPE_WITHOUT_MILK_ALLERGY
                INNER JOIN Review 
                ON RECIPE_WITHOUT_MILK_ALLERGY.RECIPE_ID_WITHOUT_MILK_ALLERGY=Review.RecipeID
                GROUP BY Review.RecipeID
                ORDER BY AVG(Review.Rating) DESC, Review.RecipeID ASC
                LIMIT 10) AS T 
                WHERE T.id = Recipe.RecipeID;";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
                array_push($res, $row);
            }
            return $res;
        }

        public function insertRecipe($recipe){
            $recipeName = $recipe["RecipeName"];
            $imageUrl = $recipe["ImageUrl"];
            $sql = "INSERT INTO Recipe(RecipeName, ImageUrl) VALUES('$recipeName', '$imageUrl');";
            $conn = $this->connectionManager->getConnection();
            $conn->query($sql);
            $recipe["RecipeID"] = mysqli_insert_id($conn);
            return $recipe;
        }

        public function updateRecipe($recipe){
            $recipeID = $recipe["RecipeID"];
            $recipeName = $recipe["RecipeName"];
            $imageUrl = $recipe["ImageUrl"];
            $sql = "UPDATE Recipe SET RecipeName = '$recipeName', ImageUrl = '$imageUrl' WHERE RecipeID = '$recipeID'";
            $conn = $this->connectionManager->getConnection();
            $conn->query($sql);
            return $recipe;
        }

        public function deleteRecipe($id){
            $sql = "DELETE FROM Recipe WHERE RecipeID = '$id'";
            $conn = $this->connectionManager->getConnection();
            $conn->query($sql);
            return $id;
        }
    }
?>