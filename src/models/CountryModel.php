<?php

namespace src\models;

use src\core\Model;

class CountryModel extends Model
{
    public function setCountry($name, $prefix)
    {
        $SQL = <<<'SQL'
        INSERT INTO Countries
        (`ID`,`Name`,`Prefix`)
        VALUES
        (NULL,':name', ':prefix');
SQL;
        return $this->queryExecute($SQL, ['name' => $name, 'prefix' => $prefix]);
    }
}