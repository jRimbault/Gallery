<?php

use Gallery\Path;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Utils\Http\Json;

$scanner = new Scan(Path::Gallery());

Json::Response(array_map(function($value) {
    return $value . '.jpg';
}, $scanner->getGalleries()));

