<?php

namespace Utils;


class Router
{
    public $request;

    public function __construct()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->request = $uri;
    }

    public function get($route, $file)
    {
        if ($this->request == trim($route, '/')) {
            require_once Constant::CONFIG . 'view/' . $file . '.php';
            die();
        }
    }

    public function notFound()
    {
        http_response_code(404);
        require_once Constant::CONFIG . 'view/404.php';
        die();
    }
}
