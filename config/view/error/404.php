<?php

use Gallery\Utils\Http\Json;
use Gallery\Utils\Http\Request;

$request = new Request();

if ($request->getMethod() !== 'GET') {
    Json::Response([
        'status' => 404,
        'message' => 'Not found',
    ], 404);
}

http_response_code(404);

require_once '404.html';
