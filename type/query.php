<?php
require_once __DIR__."/../dao/RecipeDao.php";
require_once __DIR__."/../dao/IngredientDao.php";
require_once __DIR__."/../dao/ReviewDao.php";
require_once __DIR__."/recipeType.php";
require_once __DIR__."/recipeConnectionType.php";
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
        "topRecipes"=>[
            "type"=>Type::listOf($recipeType),
            "resolve"=>function($root,$args){
                return RecipeDao::getInstance()->getTop10Recipes();
            }
        ],
        "topRecipesWithoutAllergy"=>[
            "type"=>Type::listOf($recipeType),
            "args"=>[
                "allergy"=>Type::string()
            ],
            "resolve"=>function($root,$args){
                return RecipeDao::getInstance()->getTop10RecipesWithoutAllergy($args["allergy"]);
            }
        ],
        "recipes"=>[
            "type"=>$recipeConnectionType,
            "args"=>[
                "first"=>Type::int(),
                "after"=>Type::id()
            ],
            "resolve"=>function($rootValue, $args){
                return RecipeDao::getInstance()->getRecipesByPage($args["first"],$args["after"]);
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
        ],
        "allergies"=>[
            "type"=>Type::listOf(Type::string()),
            "resolve"=>function($root,$args){
                return AllergyTypeDao::getInstance()->getAllergies();
            }
        ]
    ]
]);