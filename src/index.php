<?php

use src\core\Api;

require_once '../vendor/autoload.php';

function main()
{
    try{
        $process = new Api();
    }
    catch (Exception $e){
        echo header('Content-Type: application/json; charset=utf8');
        echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
    }
}

main();
