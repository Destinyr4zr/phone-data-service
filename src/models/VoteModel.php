<?php

namespace src\models;


use src\core\Model;

class VoteModel extends Model
{
    public function setVoteByReview($reviewID, $ip, $action)
    {
        $rating=$action=='down'?'-1':'1';
        $SQL=<<<'SQL'
        INSERT INTO Votes
        (`ID`,`rating`,`IP`,`ReviewID`)
        VALUES(NULL, ':rating', ':ip', ':review');
SQL;
        return $this->queryExecute($SQL,['rating'=>$rating,'review' => $reviewID,'ip'=>$ip]);
    }
}