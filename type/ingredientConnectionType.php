<?php

require_once __DIR__."/ingredientType.php";
require_once __DIR__."/pageInfoType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$ingredientEdge = new ObjectType([
    "name"=>"IngredientEdge",
    "fields"=>[
        "node"=>$ingredientType,
        "cursor"=>Type::id()
    ]
]);

$ingredientConnectionType = new ObjectType([
    "name"=>"IngredientConnection",
    "fields"=>[
        "pageInfo"=>$pageInfo,
        "edges"=>Type::listOf($ingredientEdge)
    ]
]);