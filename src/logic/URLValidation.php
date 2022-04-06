<?php

namespace src\logic;

use Exception;

class URLValidation extends Validation
{
    public function check($url = NULL)
    {
        if (count($_GET)==0) {
            throw new Exception(PARSE_ERROR);
        }
        return true;
    }
}