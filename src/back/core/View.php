<?php
namespace src\core;
use Latte\Engine;

class View
{
    protected $latte;

    public function __construct()
    {
        $this->latte = new Engine;
// cache directory
        $this->latte->setTempDirectory('/path/to/tempdir');
    }

    public function render($filename, $params)
    {
// or $params = new TemplateParameters(/* ... */);
        $this->latte->render('template.latte', $params);
    }
}