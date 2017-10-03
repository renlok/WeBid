<?php

namespace WeBid\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
    protected $ci;
    protected $view;
    protected $em;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
        $this->view = $ci->get('view');
        $this->em = $ci->get('em');
    }
}