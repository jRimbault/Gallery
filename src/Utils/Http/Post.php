<?php

namespace Gallery\Utils\Http;


class Post
{
    private $post;
    public function __construct() { $this->post = $_POST; }
    public function get(string $index) {
        return $this->post[$index] ?? null;
    }
    /** send a POST request to designated URI */
    public function do(string $uri, array $params = [])
    {
        return file_get_contents(
            $uri,
            false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($params)
                ]
            ])
        );
    }
}
