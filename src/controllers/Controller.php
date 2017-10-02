<?php

namespace Src\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
    protected $ci;
    protected $view;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
        $this->view = $ci->get('view');
    }
}