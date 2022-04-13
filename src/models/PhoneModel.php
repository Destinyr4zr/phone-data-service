<?php

namespace src\models;

use src\core\Model;

class PhoneModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setPhone($prefix,$phone)
    {
        $SQL=<<<'SQL'
        INSERT INTO Phones
        (`ID`,`phone`,`countryID`)
        VALUES
        (NULL,':phone', (SELECT ID from Countries WHERE prefix=':prefix'));
SQL;
        return $this->queryExecute($SQL,['prefix' => $prefix,'phone'=>$phone]);
    }

    public function getPhoneByPattern($pattern)
    {
        $SQL=<<<'SQL'
        SELECT Phones.phone, COUNT(Reviews.phoneID)
        FROM Phones JOIN Reviews ON Phones.ID = Reviews.phoneID
        WHERE phone LIKE ':phone%' GROUP BY Phones.phone;
SQL;
        return $this->queryExecute($SQL,['phone' => $pattern]);
    }
}