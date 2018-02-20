<?php

namespace Gallery\Utils\Http;


class Get
{
    private $get;
    public function __construct() { $this->get = $_GET; }
    public function get(string $index) {
        return $this->get[$index] ?? null;
    }
    /** send a GET request to designated URI */
    public function do(string $uri, array $params = [])
    {
        return file_get_contents(
            $uri . '?' . http_build_query($params),
            false,
            /**
             * this is slightly useless for GET requests, since it default to GET,
             * but if we want to add other options (headers), it's there
             */
            stream_context_create([
                'http' => [
                    'method' => 'GET',
                ],
            ])
        );
    }
}
