<?php
require "./RecipeDao.php";
require "./RecipeIngredientDao.php";
require "./IngredientDao.php";
require "./AllergyTypeDao.php";

if($_POST["recipeId"]){
    $recipeDao = RecipeDao::getInstance();
    var_dump($recipeDao->getRecipeById($_POST["recipeId"]));
    
    $recipeIngredientDao = RecipeIngredientDao::getInstance();
    var_dump($recipeIngredientDao->getIngredientIdsByRecipeId($_POST["recipeId"]));
}

if($_POST["ingredientId"]){
    $ingredientDao = IngredientDao::getInstance();
    var_dump($ingredientDao->getIngredientByIngredientId($_POST["ingredientId"]));
}

if($_POST["allergyTypeId"]){
    $allergyTypeDao = AllergyTypeDao::getInstance();
    var_dump($allergyTypeDao->getAllergyTypeByAllergyTypeId($_POST["allergyTypeId"]));
}