<?php

namespace src\core;

use src\core\Router;
use src\logic\URLValidation;
use Exception;

require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'../config/api_config.php');

//TODO: use DIC

class Api
{
    protected $router;
    public function __construct()
    {
        try {
            if ((new URLValidation())->check()) {
                $this->router= new Router();
            }
        } catch (Exception $e) {
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
        return true;
    }
}