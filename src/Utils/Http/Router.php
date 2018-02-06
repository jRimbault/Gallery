<?php

namespace Gallery\Utils\Http;

use Gallery\Utils\Http\Request;
use Gallery\Path;


class Router extends Request
{
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
        if (is_string($method) && $method === $this->getRequest('METHOD')) {
            return true;
        }
        if (is_array($method) && in_array($this->getRequest('METHOD'), $method)) {
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
            if ($route === $this->getRequest('URI')) {
                return true;
            }
        }
        if (is_array($route)) {
            array_walk($route, function ($value) {
                return trim($value, '/');
            });
            if (in_array($this->getRequest('URI'), $route)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Defines a new route
     * @param string|array $route request uri to access the ressource
     * @param string $file view file handling the request
     * @param string|array $method list of methods authorized to access the ressource
     */
    public function add($route, $file, $method = 'GET')
    {
        if (!$this->checkMethod($method)) return;
        if (!$this->checkRoute($route)) return;
        require_once Path::View() . '/' . $file . '.php';
        die();
    }

    /**
     * Return a 404 error to the client
     */
    public function notFound($file)
    {
        requireFile(Path::View() . $file . '.php');
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
