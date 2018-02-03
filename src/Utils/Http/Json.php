<?php

namespace Gallery\Utils\Http;


class Json
{
    /**
     * Send a JSON payload to the client and an http responde code
     * and terminates the program
     * Shortcut method
     */
    public static function Response($array, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
