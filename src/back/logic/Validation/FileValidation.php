<?php
namespace src\logic;
use Exception;

class FileValidation extends Validation
{
    public function check($path){
        if (!file_exists($path)) {
            throw new Exception($this->object_name." path does not exist");
        }
        else return true;
    }
}