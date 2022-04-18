<?php
namespace src\core;
use src\router\Someclass;
use src\router\Middleware;
use Klein\Klein;
use Exception;


class Router
{
    protected $middleware;
    public function __construct()
    {
        try {
            $klein = new Klein();
            $this->middleware=new Middleware();
            $klein->respond('GET', '/reviews', [$this->middleware,'reviewsHandler']);
            $klein->respond('GET', '/review', [$this->middleware,'reviewHandler']);
            $klein->respond('POST', '/review', [$this->middleware,'reviewHandler']);
            $klein->respond('GET', '/phone', [$this->middleware,'phoneHandler']);
            $klein->respond('POST', '/vote/{up|down:action}', [$this->middleware,'voteHandler']);
            $klein->dispatch();
        } catch (Exception $e) {
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }
}