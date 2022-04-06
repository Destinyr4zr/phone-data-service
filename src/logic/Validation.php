<?php
namespace src\logic;


abstract class Validation
{
    protected $object_name;
    protected $exception_text;
    protected $object;

    public function __construct($object_name=NULL,$exception_text=NULL)
    {
        $this->object_name=$object_name;
        $this->exception_text=$exception_text;
    }
    abstract public function check($object);
}