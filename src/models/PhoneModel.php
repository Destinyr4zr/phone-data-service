<?php

namespace src\models;

use src\core\Model;

class PhoneModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPhone()
    {

    }

    public function setPhone()
    {

    }

    public function searchPhone($pattern)
    {
        $stmt = $this->pdo->prepare('SELECT Phones.phone, COUNT (Reviews.review) OVER (PARTITION BY Phones.phone) AS reviewNumber   FROM Phones JOIN Reviews  ON Phones.ID = Reviews.phoneID WHERE phone LIKE "%:phone"');
        $stmt->execute(['phone' => $pattern]);
        return $stmt->fetch();
    }
}