<?php

namespace Gallery\Utils\Http;


class Server
{
    private $server;
    public function __construct() { $this->server = $_SERVER; }
    public function get(string $index) {
        return trim($this->server[$index] ?? null, '/') ;
    }
}
