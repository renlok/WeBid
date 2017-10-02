<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    public function home($request, $response, $args) {
        return $this->view->render($response, 'home.html', [
            'name' => 'Chris'
        ]);
    }
}