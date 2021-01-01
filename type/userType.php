<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$userType = new ObjectType([
    "name"=>"User",
    "fields"=>[
        "UserId"=>Type::nonNull(Type::id()),
        "UserName"=>Type::string(),
        "UserPass"=>Type::string(),
        "FirstName"=>Type::string(),
        "Email"=>Type::string()
    ]
]);