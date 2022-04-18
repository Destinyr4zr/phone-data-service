<?php
namespace src\models;

use src\core\Model;

class ReviewModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReviewByID($id){
        $SQL=<<<'SQL'
        SELECT review, author 
        FROM Reviews 
        WHERE Review.ID= :id;
SQL;
        return $this->queryExecute($SQL,['id'=>$id]);
    }
    public function setReviewByPhone($phone, $name, $review){
        $SQL=<<<'SQL'
        INSERT INTO Reviews
        (`id`,`author`,`Review`,`phoneID`)
        SELECT NULL, :author, :review,Phones.phoneID 
        FROM Phones
        WHERE Phones.phone = :phone;
SQL;
        return $this->queryExecute($SQL,['phone' => $phone,'author' => $name,'review'=>$review]);
    }
    public function getReviewsByPhone($phone){
        $SQL=<<<'SQL'
        SELECT review, author 
        FROM Reviews 
        JOIN Phones
        ON Phones.ID = Reviews.phoneID AND Phones.phone=:phone;
SQL;
        return $this->queryExecute($SQL,['phone' => $phone]);
    }
}