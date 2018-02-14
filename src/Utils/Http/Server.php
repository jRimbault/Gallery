<?php

namespace Gallery\Utils\Http;


class Server
{
    private $server;

    public function __construct() { $this->server = $_SERVER; }

    public function get(string $index) {
        return trim($this->server[$index] ?? null, '/');
    }

    public function getRequest(string $index)
    {
        return $this->get('REQUEST_' . strtoupper($index));
    }

    public function getHttp(string $index)
    {
        return $this->get('HTTP_' . strtoupper($index));
    }
}
