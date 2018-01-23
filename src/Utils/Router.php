<?php

namespace Utils;


class Router
{
    private $uri;
    private $method;

    public function __construct()
    {
        $this->uri = trim($this->getURI(), '/');
        $this->method = $this->getMethod();
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
        if (is_string($route)) {
            $route = trim($route, '/');
            if ($route === $this->uri) {
                return true;
            }
        }
        if (is_array($route)) {
            array_walk($route, function($value) {
                return trim($value, '/');
            });
            if (in_array($this->uri, $route)) {
                return true;
        }
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

    public function __call($method, $params)
    {
        if (strncasecmp($method, 'get', 3) !== 0) return;
        $var = strtoupper(substr($method, 3));
        if (!isset($_SERVER['REQUEST_' . $var])) return;

        return $_SERVER['REQUEST_' . $var];
    }
}
