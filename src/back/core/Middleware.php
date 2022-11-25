<?php

namespace src\router;

use src\core\Callback;
use src\models\ReviewModel;
use src\models\VoteModel;
use src\models\PhoneModel;

class Middleware extends Callback
{
    public function __construct(){

    }
    public function reviewsHandler($request)
    {
        $reviews = (new ReviewModel())->getReviewsByPhone($request->param('phone'));
        $this->successResponseSend(200, 'Reviews got!', $reviews);
    }

    public function reviewHandler($request)
    {
        if ($request->method('get')){
            $review = (new ReviewModel())->getReviewByID($request->param('reviewID'));
            $this->successResponseSend(200,'Review got!', $review);
        }
        else if ($request->method('post')){
            (new ReviewModel())->setReviewByPhone($request->param('phone'), $request->param('name'), $request->param('review'));
            $this->successResponseSend(200, 'Review added!');
        }
    }

    public function phoneHandler($request)
    {
        $phone = (new PhoneModel())->getPhoneByPattern($request->param('pattern'));
        $this->successResponseSend(200, 'Phone found!',$phone);
    }

    public function voteHandler($request)
    {
        (new VoteModel())->setVoteByReview($request->param('reviewID'), $request->param('ip'),$request->action);
        $this->successResponseSend(200, 'Vote updated!');
    }

    public function phoneViewHandler($request)
    {
        (new VoteModel())->setVoteByReview($request->param('reviewID'), $request->param('ip'),$request->action);
        $this->successResponseSend(200, 'Vote updated!');
    }

    public function mainViewHandler($request)
    {
        (new VoteModel())->setVoteByReview($request->param('reviewID'), $request->param('ip'),$request->action);
        $this->successResponseSend(200, 'Vote updated!');
    }

    protected function successResponseSend($code, $message, $body=NULL)
    {
        echo header('Content-Type: application/json; charset=utf8');
        echo json_encode(["response" => "true", "body" => ["source" => "$_SERVER[SERVER_NAME]", "response_code" => $code, "response_msg" => $message, "response_body"=>$body]]);
    }
}