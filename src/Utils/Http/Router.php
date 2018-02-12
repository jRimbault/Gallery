<?php

namespace Gallery\Utils\Http;

use Gallery\Path;
use Gallery\Utils\Http\Request;


class Router extends Request
{
    private $routes;

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
            $method === $this->server()->getRequest('METHOD')) {
            return true;
        }
        if (is_array($method) &&
            in_array($this->server()->getRequest('METHOD'), $method)) {
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
            if ($uri === $this->server()->getRequest('URI')) {
                return true;
            }
        }
        if (is_array($uri)) {
            array_walk($uri, function ($value) {
                return trim($value, '/');
            });
            if (in_array($this->server()->getRequest('URI'), $uri)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Defines a new route
     * @param string|array $method   list of methods authorized to access the ressource
     * @param string|array $route    request uri
     * @param string       $callback function handling the request
     */
    public function add($method, $uri, $callback)
    {
        $this->routes[] = (object) [
            'method'   => $method,
            'uri'      => $uri,
            'callback' => $callback,
        ];
    }

    public function start()
    {
        foreach($this->routes as $route) {
            if (!$this->checkMethod($route->method)) continue;
            if (!$this->checkUri($route->uri)) continue;
            call_user_func($route->callback, new Request());
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
        require new Path("/config/view//error/404.php");
    }
}
