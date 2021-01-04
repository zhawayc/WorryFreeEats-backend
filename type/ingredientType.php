<?php
require_once __DIR__."/../dao/AllergyTypeDao.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$ingredientType = new ObjectType([
    "name"=>"Ingredient",
    "fields"=>[
        "id"=>[
            "type"=>Type::nonNull(Type::id()),
            "resolve"=>function($rootValue, $args){
                return $rootValue["IngredientId"];
            }
        ],
        "Name"=>Type::string(),
        "AllergyType"=>[
            "type"=>Type::string(),
            "resolve"=>function($rootValue, $args){
                return AllergyTypeDao::getInstance()->getAllergyTypeByAllergyTypeId($rootValue["AllergyTypeId"]);
            }
        ]
    ]
]);