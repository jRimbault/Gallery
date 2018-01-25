<?php

namespace Gallery\Utils\Http;


class Request
{
    public function __construct()
    {
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
