<?php

namespace src\models;


use src\core\Model;

class VoteModel extends Model
{
    public function upVote($reviewID,$ip)
    {
        $stmt = $this->pdo->prepare('UPDATE Votes SET rating=rating+1,ip=:ip WHERE reviewID =:review');
        $stmt->execute(['reviewID' => $reviewID,'ip'=>$ip]);
        return $stmt->fetch();
    }

    public function downVote($reviewID,$ip)
    {
        $stmt = $this->pdo->prepare('UPDATE Votes SET rating=rating-1,ip=:ip WHERE reviewID =:review');
        $stmt->execute(['reviewID' => $reviewID,'ip'=>$ip]);
        return $stmt->fetch();
    }
}