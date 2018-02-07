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
    private $_get;
    private $_post;
    private $_server;

    public function __construct()
    {
        $this->_get = new Get();
        $this->_post = new Post();
        $this->_server = new Server();
    }

    public function get() { return $this->_get; }
    public function post() { return $this->_post; }
    public function server() { return $this->_server; }
}
