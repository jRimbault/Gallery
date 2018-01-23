<?php

namespace Utils;


class Json
{
    public static function Response($array, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
