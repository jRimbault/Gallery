<?php

namespace Utils;


class Router
{
    private $request;
    private $method;

    public function __construct()
    {
        $this->request = trim($_SERVER['REQUEST_URI'], '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Dedicated function to checking the method because $method
     * can be of mixed type
     * @param string|array $method
     */
    private function checkMethod($method)
    {
        if (is_string($method) && $method === $this->method) {
            return true;
        }
        if (is_array($method) && in_array($this->method, $method)) {
            return true;
        }
        return false;
    }

    /**
     * Dedicated function to checking the route because $route
     * can be of mixed type
     * @param string|array $route
     */
    private function checkRoute($route)
    {
        $route = trim($route, '/');
        if (is_string($route) && $route === $this->request) {
            return true;
        }
        if (is_array($route) && in_array($this->request, $route)) {
            return true;
        }
        return false;
    }

    /**
     * Defines a new route
     * @param string|array $route  request uri to access the ressource
     * @param string       $file   view file handling the request
     * @param string|array $method list of methods authorized to access the ressource
     */
    public function get($route, $file, $method = 'GET')
    {
        if (!$this->checkMethod($method)) return;
        if (!$this->checkRoute($route)) return;
        require_once Constant::CONFIG . 'view/' . $file . '.php';
        die();
    }

    /**
     * Return a 404 error to the client
     */
    public function notFound()
    {
        require_once Constant::CONFIG . 'view/error/404.php';
        die();
    }
}
