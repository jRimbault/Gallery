<?php

namespace Gallery\Utils\Http;

use Gallery\Utils\Http\Request;
use Gallery\Path;


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
     * @param string|array $route request uri to access the ressource
     * @param string       $file view file handling the request
     * @param string|array $method list of methods authorized to access the ressource
     */
    public function add($uri, $file, $method = 'GET')
    {
        $this->routes[] = (object) [
            'method' => $method,
            'uri'    => $uri,
            'file'   => $file,
        ];
    }

    public function start()
    {
        foreach($this->routes as $route) {
            if (!$this->checkMethod($route->method)) continue;
            if (!$this->checkUri($route->uri)) continue;
            requireFile(new Path("/config/view/$route->file.php"));
            die();
        }
        $this->notFound('/error/404');
    }

    /**
     * Return a 404 error to the client
     */
    private function notFound($file)
    {
        requireFile(new Path("/config/view/$file.php"));
        die();
    }
}

/**
 * Scope isolated include
 *
 * Prevents access to $this/self from included files
 * But allows injecting variables through the array $params
 */
function requireFile($file, array $params = [])
{
    require $file;
}
