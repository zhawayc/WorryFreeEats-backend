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
                "id"=>Type::id()
            ],
            "resolve"=>function($parentValue,$args){
                return RecipeDao::getInstance()->deleteRecipe($args["id"]);
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
                "id"=>Type::id()
            ],
            "resolve"=>function($parentValue,$args){
                return ReviewDao::getInstance()->deleteReview($args["id"]);
            }
        ],
        "userLogin"=>[
            "type"=>$userType,
            "args"=>[
                "UserName"=>Type::string(),
                "UserPass"=>Type::string()
            ],
            "resolve"=>function($root,$args){
                $user=UserDao::getInstance()->userLogin($args);
                if($user!=null){
                    setcookie("user", $user["UserId"], time()+3600);
                }
                return $user;
            }
        ],
        "userRegister"=>[
            "type"=>$userType,
            "args"=>[
                "UserName"=>Type::nonNull(Type::string()),
                "UserPass"=>Type::nonNull(Type::string()),
                "FirstName"=>Type::string(),
                "Email"=>Type::string()
            ],
            "resolve"=>function($root,$args){
                if(UserDao::getInstance()->getUserByUserName($args["UserName"])){
                    return null;
                }
                $user = UserDao::getInstance()->insertUser($args);
                setcookie("user", $user["UserId"]);
                return $user;
            }
        ]
    ]
]);