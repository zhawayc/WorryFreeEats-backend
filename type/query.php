<?php
require_once __DIR__."/../dao/RecipeDao.php";
require_once __DIR__."/../dao/IngredientDao.php";
require_once __DIR__."/../dao/ReviewDao.php";
require_once __DIR__."/recipeType.php";
require_once __DIR__."/ingredientType.php";
require_once __DIR__."/reviewType.php";
require_once __DIR__."/userType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$queryType = new ObjectType([
    "name"=>"Query",
    "fields"=>[
        "echo"=>[
            "type"=>Type::string(),
            "args"=>[
                "message"=>Type::nonNull(Type::string())
            ],
            "resolve"=>function($root,$args){
                return $root["pre  fix"].$args["message"];
            }
        ],
        "recipe"=>[
            "type"=>$recipeType,
            "args"=>[
                "id"=>Type::nonNull(Type::id())
            ],
            "resolve"=>function($root,$args){
                return RecipeDao::getInstance()->getRecipeById($args["id"]);
            }
        ],
        "recipes"=>[
            "type"=>Type::listOf($recipeType),
            "resolve"=>function(){
                return RecipeDao::getInstance()->getRecipes();
            }
        ],
        "ingredient"=>[
            "type"=>$ingredientType,
            "args"=>[
                "id"=>Type::nonNull(Type::id())
            ],
            "resolve"=>function($root,$args){
                return IngredientDao::getInstance()->getIngredientByIngredientId($args["id"]);
            }
        ],
        "reviewsByRecipeId"=>[
            "type"=>Type::listOf($reviewType),
            "args"=>[
                "id"=>Type::nonNull(Type::id())
            ],
            "resolve"=>function($root,$args){
                return ReviewDao::getInstance()->getReviewByRecipeId($args["id"]);
            }
        ],
        "user"=>[
            "type"=>$userType,
            "args"=>[
                "id"=>Type::nonNull(Type::id())
            ],
            "resolve"=>function($root,$args){
                return UserDao::getInstance()->getUserByUserId($args["id"]);
            }
        ]
    ]
]);