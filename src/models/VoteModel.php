<?php

namespace src\models;


use src\core\Model;

class VoteModel extends Model
{
    public function upVote($reviewID)
    {
        $stmt = $this->pdo->prepare('UPDATE Votes SET rating=rating+1 WHERE reviewID =:review');
        $stmt->execute(['reviewID' => $reviewID]);
        return $stmt->fetch();
    }

    public function downVote($reviewID)
    {
        $stmt = $this->pdo->prepare('UPDATE Votes SET rating=rating-1 WHERE reviewID =:review');
        $stmt->execute(['reviewID' => $reviewID]);
        return $stmt->fetch();
    }
}