<?php


namespace src\core;

use Klein\Klein;
use src\models\PhoneModel;
use src\models\ReviewModel;
use src\models\VoteModel;

class Router
{
    protected $model;
    public function __construct()
    {
        $klein = new Klein();
        $klein->respond('GET', '/reviews', function ($request, $response) {
            $this->model=new ReviewModel();
            $reviews = $this->model->getReviews($request->param('phone'));
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => 200, "response_msg" => json_encode($reviews)]]);
        });
        $klein->respond('GET', '/review', function ($request, $response) {
            $this->model=new ReviewModel();
            $review=$this->model->getReview($request->param('reviewID'));
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => 200, "response_msg" => "$review"]]);
        });
        $klein->respond('POST', '/review', function ($request, $response) {
            $this->model=new ReviewModel();
            $this->model->setReview($request->param('phone'),$request->param('name'));
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => 200, "response_msg" => 'Review added!']]);
        });
        $klein->respond('GET', '/phone}', function ($request, $response) {
            $this->model=new PhoneModel();
            $phone=$this->model->searchPhone($request->param('pattern'));
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => 200, "response_msg" => "$phone"]]);
        });
        $klein->respond('POST', '/vote/{up|down:action}', function ($request, $response) {
            $this->model=new VoteModel();
            if($request->action=='up'){
                $this->model->upVote($request->param('reviewID'));
            }
            elseif($request->action=='down')
            {
                $this->model->downVote($request->param('reviewID'));
            }
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => 200, "response_msg" => 'Vote updated!']]);
        });
        $klein->dispatch();
    }
}