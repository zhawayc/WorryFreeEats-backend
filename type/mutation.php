<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
require_once __DIR__."/recipeType.php";
require_once __DIR__."/../dao/RecipeDao.php";
require_once __DIR__."/reviewType.php";
require_once __DIR__."/../dao/ReviewDao.php";

$mutationType = new ObjectType([
    "name"=>"Mutation",
    "fields"=>[
        "addRecipe"=>[
            "type"=>$recipeType,
            "args"=>[
                "RecipeName"=>Type::nonNull(Type::string()),
                "ImageUrl"=>Type::string()
            ],
            "resolve"=>function($parentValue,$args){
                return RecipeDao::getInstance()->insertRecipe($args);
            }
        ],
        "updateRecipe"=>[
            "type"=>$recipeType,
            "args"=>[
                "RecipeID"=>Type::nonNull(Type::id()),
                "RecipeName"=>Type::string(),
                "ImageUrl"=>Type::string()
            ],
            "resolve"=>function($parentValue,$args){
                return RecipeDao::getInstance()->updateRecipe($args);
            }
        ],
        "deleteRecipe"=>[
            "type"=>Type::int(),
            "args"=>[
                "RecipeID"=>Type::id()
            ],
            "resolve"=>function($parentValue,$args){
                return RecipeDao::getInstance()->deleteRecipe($args["RecipeID"]);
            }
        ],
        "addReview"=>[
            "type"=>$reviewType,
            "args"=>[
                "ReviewText"=>Type::string(),
                "RecipeID"=>Type::id(),
                "Rating"=>Type::int(),
                "UserId"=>Type::id()
            ],
            "resolve"=>function($parentValue,$args){
                return ReviewDao::getInstance()->insertReview($args);
            }
        ],
        "updateReview"=>[
            "type"=>$reviewType,
            "args"=>[
                "ReviewId"=>Type::nonNull(Type::id()),
                "ReviewText"=>Type::string(),
                "RecipeID"=>Type::id(),
                "Rating"=>Type::int(),
                "UserId"=>Type::id()
            ],
            "resolve"=>function($parentValue,$args){
                return ReviewDao::getInstance()->updateReview($args);
            }
        ],
        "deleteReview"=>[
            "type"=>Type::int(),
            "args"=>[
                "id"=>Type::int()
            ],
            "resolve"=>function($parentValue,$args){
                return ReviewDao::getInstance()->deleteReview($args["id"]);
            }
        ]
    ]
]);