<?php
namespace src\core;
use PDO;
use Exception;

require_once('src\config\db_config.php');

//TODO: submodel SQL implement


class Model
{
    protected $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new PDO(DBMS . ':host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
        }
        catch (Exception $e){
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }
}