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
            $klein->respond('GET', '/reviews', 'reviewsHandler');
            $klein->respond('GET', '/review', 'reviewHandler');
            $klein->respond('POST', '/review', 'reviewHandler');
            $klein->respond('GET', '/phone', 'phoneHandler');
            $klein->respond('POST', '/vote/{up|down:action}', 'voteHandler');
            $klein->dispatch();
        } catch (Exception $e) {
            echo header('Content-Type: application/json; charset=utf8');
            echo json_encode(["response" => "false", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $e->getCode(), "response_msg" => $e->getMessage()]]);
        }
    }

    protected function successResponseSend($code, $message)
    {
        echo header('Content-Type: application/json; charset=utf8');
        echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $code, "response_msg" => $message]]);
    }

    protected function reviewsHandler($request)
    {
        $this->model = new ReviewModel();
        $reviews = $this->model->getReviewsByPhone($request->param('phone'));
        $this->successResponseSend(200, json_encode($reviews));
    }

    protected function reviewHandler($request)
    {
        $this->model = new ReviewModel();
        if ($request->method('get')){
            $review = $this->model->getReviewByID($request->param('reviewID'));
            $this->successResponseSend(200, "$review");
        }
        else if ($request->method('post')){
            $this->model->setReviewByPhone($request->param('phone'), $request->param('name'), $request->param('review'));
            $this->successResponseSend(200, 'Review added!');
        }
    }

    protected function phoneHandler($request)
    {
        $this->model = new PhoneModel();
        $phone = $this->model->getPhoneByPattern($request->param('pattern'));
        $this->successResponseSend(200, $phone);
    }

    protected function voteHandler($request)
    {
        $this->model = new VoteModel();
        $this->model->setVoteByReview($request->param('reviewID'), $request->param('ip'),$request->action);
        $this->successResponseSend(200, 'Vote updated!');
    }
}