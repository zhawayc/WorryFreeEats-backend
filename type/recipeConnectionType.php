<?php

require_once __DIR__."/recipeType.php";
require_once __DIR__."/pageInfoType.php";
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$recipeEdge = new ObjectType([
    "name"=>"RecipeEdge",
    "fields"=>[
        "node"=>$recipeType,
        "cursor"=>Type::id()
    ]
]);

$recipeConnectionType = new ObjectType([
    "name"=>"RecipeConnection",
    "fields"=>[
        "pageInfo"=>$pageInfo,
        "edges"=>Type::listOf($recipeEdge)
    ]
]);