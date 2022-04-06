<?php
namespace src\logic;
//TODO: advanced validation


class PhoneValidation extends Validation
{
    protected $text;

    public function check($object_name)
    {
        $this->text;
    }

    public function __construct($text = NULL)
    {
        $this->text=$text;
    }
}