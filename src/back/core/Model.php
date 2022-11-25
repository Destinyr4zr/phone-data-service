<?php
namespace src\core;
use PDO;
use Exception;
use PDOException;

require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'..\config\db_config.php');

//TODO: use memcached for high load
//TODO: check JSON encoding

class Model
{
    protected $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new PDO(DBMS . ':host=' . HOST . ';dbname=' . DBNAME, USER, PASS , [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
        }
        catch (PDOException $e){
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }
    protected function queryExecute($SQL, $mask){
        try{
            $stmt = $this->pdo->prepare($SQL);
            $stmt->execute($mask);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }
}