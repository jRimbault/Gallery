<?php

namespace Gallery\Utils\Http;

use Gallery\Path;
use Gallery\Utils\Http\Request;


class Router extends Request
{
    private $routes;
    private $error;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Dedicated function to checking the method because $method
     * can be of mixed type
     * @param string|array $method
     */
    private function checkMethod($method)
    {
        if (is_string($method) &&
            $method === $this->server()->getRequest('method')) {
            return true;
        }
        if (is_array($method) &&
            in_array($this->server()->getRequest('method'), $method)) {
            return true;
        }
        return false;
    }

    /**
     * Dedicated function to checking the route because $route
     * can be of mixed type
     * @param string|array $route
     */
    private function checkUri($uri)
    {
        if (is_string($uri)) {
            $uri = trim($uri, '/');
            if ($uri === $this->server()->getRequest('uri')) {
                return true;
            }
        }
        if (is_array($uri)) {
            array_walk($uri, function ($value) {
                return trim($value, '/');
            });
            if (in_array($this->server()->getRequest('uri'), $uri)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Defines a new route
     * @param string|array $uri      route path(s)
     * @param callable     $callback function handling the request
     * @param string|array $method   http method(s) to access the ressource
     */
    public function add($uri, callable $callback, $method = 'GET')
    {
        $this->routes[] = [
            'method'   => $method,
            'uri'      => $uri,
            'callback' => $callback,
        ];
    }

    /**
     * @param string $callback function handling the error
     */
    public function error($callback)
    {
        $this->error = $callback;
    }

    /**
     * Search if the current request matches a route
     */
    public function start()
    {
        foreach($this->routes as $route) {
            if (!$this->checkMethod($route['method'])) continue;
            if (!$this->checkUri($route['uri'])) continue;
            call_user_func($route['callback'], new Request());
            die();
        }
        $this->notFound();
        die();
    }

    /**
     * Return a 404 error to the client
     */
    private function notFound()
    {
        call_user_func($this->error, new Request());
    }
}
