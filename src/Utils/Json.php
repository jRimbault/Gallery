<?php

namespace Utils;


class Json
{
    public static function response($array, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($array));
    }
}
