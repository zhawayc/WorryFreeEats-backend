<?php
require_once __DIR__."/../dao/RecipeDao.php";
require_once __DIR__."/../dao/RecipeIngredientDao.php";
require_once __DIR__."/ingredientType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$recipeType = new ObjectType([
    "name"=>"Recipe",
    "fields"=>[
        "RecipeID"=>Type::nonNull(Type::id()),
        "RecipeName"=>Type::string(),
        "ImageUrl"=>Type::string(),
        "Ingredients"=>[
            "type"=>Type::listOf($ingredientType),
            "resolve"=>function($rootValue, $args){
                $arrId = RecipeIngredientDao::getInstance()->getIngredientIdsByRecipeId($rootValue["RecipeID"]);
                return array_map(function($id){
                    return IngredientDao::getInstance()->getIngredientByIngredientId($id["IngredientId"]);
                }, $arrId);
            }
        ]
    ]
]);