<?php

namespace Utils;


class Router
{
    public $request;

    public function __construct()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        // $uri = explode('/', $uri);
        $this->request = $uri;
    }

    public function get($route, $file)
    {
        if ($this->request == trim($route, '/')) {
            require_once Constant::SRC . 'view/' . $file . '.php';
            die();
        }
    }
}
