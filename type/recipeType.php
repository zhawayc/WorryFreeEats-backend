<?php
require_once __DIR__."/../dao/RecipeDao.php";
require_once __DIR__."/../dao/RecipeIngredientDao.php";
require_once __DIR__."/ingredientType.php";
require_once __DIR__."/ingredientConnectionType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$recipeType = new ObjectType([
    "name"=>"Recipe",
    "fields"=>[
        "id"=>[
            "type"=>Type::nonNull(Type::id()),
            "resolve"=>function($rootValue, $args){
                return $rootValue["RecipeID"];
            }
        ],
        "RecipeName"=>Type::string(),
        "ImageUrl"=>Type::string(),
        "Ingredients"=>[
            "type"=>$ingredientConnectionType,
            "args"=>[
                "first"=>Type::int(),
                "after"=>Type::id()
            ],
            "resolve"=>function($rootValue, $args){
                $page = RecipeIngredientDao::getInstance()->getIngredientIdsByRecipeIdAndPage($rootValue["RecipeID"],$args["first"],$args["after"]);
                return ["pageInfo"=>$page["pageInfo"], "edges"=>array_map(function($edge){
                    return ["node"=>IngredientDao::getInstance()->getIngredientByIngredientId($edge["node"]["IngredientId"]),
                    "cursor"=>$edge["cursor"]];
                }, $page["edges"])];
            }
        ]
    ]
]);