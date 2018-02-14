<?php

namespace Gallery\Utils\Http;

use Gallery\Utils\Http\Get;
use Gallery\Utils\Http\Post;
use Gallery\Utils\Http\Cookie;
use Gallery\Utils\Http\Server;


/**
 * Allow operating on $_SERVER without risk of overwriting data
 */
class Request
{
    private $_get;
    private $_post;
    private $_server;
    private $_cookie;

    public function __construct()
    {
        $this->_get = new Get();
        $this->_post = new Post();
        $this->_server = new Server();
        $this->_cookie = new Cookie();
    }

    public function get() { return $this->_get; }
    public function post() { return $this->_post; }
    public function server() { return $this->_server; }
    public function cookie() { return $this->_cookie; }
}
