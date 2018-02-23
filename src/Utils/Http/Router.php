<?php

namespace Gallery\Utils\Http;

use Gallery\Path;
use Gallery\Utils\Http\Request;


class Router
{
    private $routes;
    private $error;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = function (Request $request) {
            die('404');
        };
    }

    /**
     * Dedicated function to checking the method because $method
     * can be of mixed type
     * @param string|array $method
     */
    private function checkMethod($method)
    {
        if (is_string($method) &&
            $method === $this->request->server()->getRequest('method')) {
            return true;
        }
        if (is_array($method) &&
            in_array($this->request->server()->getRequest('method'), $method)) {
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
            if ($uri === $this->request->server()->getRequest('uri')) {
                return true;
            }
        }
        if (is_array($uri)) {
            if (in_array($this->request->server()->getRequest('uri'), $uri)) {
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
     * @param callable $callback function handling the error
     */
    public function error(callable $callback)
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
            call_user_func($route['callback'], $this->request);
            die();
        }
        call_user_func($this->error, $this->request);
        die();
    }
}
