<?php

namespace Gallery\Utils\Http;

use Gallery\Utils\Http\Get;
use Gallery\Utils\Http\Post;
use Gallery\Utils\Http\Server;


/**
 * Allow operating on $_SERVER without risk of overwriting data
 */
class Request
{
    public $get;
    public $post;
    public $server;

    public function __construct()
    {
        $this->post = new Post();
        $this->server = new Server();
        $this->get = new Get();
    }

    public function getRequest(string $index)
    {
        return $this->server->get('REQUEST_' . strtoupper($index));
    }

    /**
     * Magic getter for $_SERVER['REQUEST_*']
     */
    public function __call($method, $params)
    {
        if (strncasecmp($method, 'get', 3) !== 0) return;
        $var = strtoupper(substr($method, 3));
        if (!isset($_SERVER['REQUEST_' . $var])) return;

        return trim($_SERVER['REQUEST_' . $var], '/');
    }
}
