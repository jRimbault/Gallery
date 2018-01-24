<?php

use Utils\Http\Json;
use Utils\Filesystem\Scan;
use Utils\Constant;

$scanner = new Scan(Constant::GALLERY);

Json::Response(array_map(function($value) {
    return $value . '.jpg';
}, $scanner->getGalleries()));

