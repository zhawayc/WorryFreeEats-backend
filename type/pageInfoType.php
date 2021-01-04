<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$pageInfo = new ObjectType([
    "name"=>"PageInfo",
    "fields"=>[
        "hasNextPage"=>Type::nonNull(Type::boolean()),
        "hasPreviousPage"=>Type::nonNull(Type::boolean()),
        "startCursor"=>Type::id(),
        "endCursor"=>Type::id()
    ]
]);