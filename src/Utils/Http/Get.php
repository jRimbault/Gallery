<?php

namespace Gallery\Utils\Http;


class Get
{
    private $get;
    public function __construct() { $this->get = $_GET; }
    public function get(string $index) {
        return $this->get[$index] ?? null;
    }
}
