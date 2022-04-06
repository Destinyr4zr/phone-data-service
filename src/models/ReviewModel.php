<?php
namespace src\models;

use src\core\Model;

class ReviewModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReview($id){
        $stmt = $this->pdo->prepare('SELECT review, author FROM Reviews WHERE Review.ID= :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function setReview($phone,$name,$review){
        $stmt = $this->pdo->prepare('INSERT INTO Reviews SELECT :review, :author,Phones.phoneID WHERE Phones.phone = :phone');
        $stmt->execute(['phone' => $phone,'name' => $name,'review'=>$review]);
        return $stmt->fetch();
    }
    public function getReviews($phone){
        $stmt = $this->pdo->prepare('SELECT review, author FROM Reviews JOIN (SELECT ID WHERE Phones.phone=:phone) AS FilterPhones ON FilterPhones.ID = Reviews.phoneID');
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetch();
    }
}