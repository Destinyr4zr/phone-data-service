<?php


namespace src\core;

use Klein\Klein;
use src\models\PhoneModel;
use src\models\ReviewModel;
use src\models\VoteModel;
use Exception;

class Router
{
    protected $model;
    public function __construct()
    {
        try {
            $klein = new Klein();
            $klein->respond('GET', '/reviews', function ($request) {
                $this->model=new ReviewModel();
                $reviews = $this->model->getReviews($request->param('phone'));
                $this->successResponseSend(200,json_encode($reviews));
            });
            $klein->respond('GET', '/review', function ($request) {
                $this->model=new ReviewModel();
                $review=$this->model->getReview($request->param('reviewID'));
                $this->successResponseSend(200, "$review");
            });
            $klein->respond('POST', '/review', function ($request) {
                $this->model=new ReviewModel();
                $this->model->setReview($request->param('phone'),$request->param('name'),$request->param('review'));
                $this->successResponseSend(200, 'Review added!');

            });
            $klein->respond('GET', '/phone}', function ($request) {
                $this->model=new PhoneModel();
                $phone=$this->model->searchPhone($request->param('pattern'));
                $this->successResponseSend(200, "$phone");
            });
            $klein->respond('POST', '/vote/{up|down:action}', function ($request) {
                $this->model=new VoteModel();
                if($request->action=='up'){
                    $this->model->upVote($request->param('reviewID'),$request->param('ip'));
                }
                elseif($request->action=='down')
                {
                    $this->model->downVote($request->param('reviewID'),$request->param('ip'));
                }
                $this->successResponseSend(200, 'Vote updated!');
            });
            $klein->dispatch();
        }
        catch (Exception $e){
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }
    protected function successResponseSend($code, $message){
        echo header('Content-Type: application/json; charset=utf8');
        echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $code, "response_msg" => $message]]);
    }
}