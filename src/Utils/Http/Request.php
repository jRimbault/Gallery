<?php

namespace Gallery\Utils\Http;

use Gallery\Utils\Http\Get;
use Gallery\Utils\Http\Post;
use Gallery\Utils\Http\Cookie;
use Gallery\Utils\Http\Server;


/**
 * Allow reading on superglobals without risk of overwriting data
 * and operating on cookies
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

    public function do(string $uri, string $method = 'GET', array $params = [])
    {
        switch (strtolower($method)) {
            case 'post':
                return $this->_post->do($uri, $params);
                break;
            case 'get':
                return $this->_get->do($uri, $params);
                break;
            default:
                return null;
                break;
        }
    }
}
