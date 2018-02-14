<?php

namespace Gallery\Utils\Http;


class Cookie
{
    public function __construct() {}
    public function get(string $index)
    {
        return $_COOKIE[strtoupper($index)] ?? null;
    }
    public function set(string $index, string $value)
    {
        $index = strtoupper($index);
        /** setting $_COOKIE to be used in the same php instance */
        $_COOKIE[$index] = $value;
        /** set cookie for future instances */
        setcookie($index, $value);
    }
}
