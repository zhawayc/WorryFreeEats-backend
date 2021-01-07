<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/type/query.php";
require_once __DIR__."/type/mutation.php";
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

$schema = new Schema([
    "query"=>$queryType,
    "mutation"=>$mutationType
]);

$rawInput = file_get_contents("php://input");
$input=json_decode($rawInput,true);
$variableValues=isset($input["variables"])?$input["variables"]:null;

$query=$input["query"];
try{
    $rootValue=["prefix"=>"You said: "];
    $result=GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output=$result->toArray();
} catch(\Exception $e){
    $output=[
        "errors"=>[
            [
                "message"=>$e->getMessage()
            ]
        ]
    ];
}
header('Content-Type: application/json');
//if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  //  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
        header('Access-Control-Allow-Credentials: true');
        //  }
//}
echo json_encode($output);