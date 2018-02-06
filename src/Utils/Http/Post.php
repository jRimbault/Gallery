<?php

namespace Gallery\Utils\Http;


class Post
{
    private $post;
    public function __construct() { $this->post = $_POST; }
    public function get(string $index) {
        return $this->post[$index] ?? null;
    }
}
