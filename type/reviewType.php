<?php
require_once __DIR__."/../dao/UserDao.php";
require_once __DIR__."/userType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$reviewType = new ObjectType([
    "name"=>"Review",
    "fields"=>[
        "ReviewId"=>Type::nonNull(Type::id()),
        "ReviewText"=>Type::string(),
        "RecipeID"=>Type::id(),
        "Rating"=>Type::int(),
        "User"=>[
            "type"=>$userType,
            "resolve"=>function($rootValue,$args){
                return UserDao::getInstance()->getUserByUserId($rootValue["UserId"]);
            }
        ]
    ]
]);