<?php


use Gallery\Utils\Filesystem\Scan;
use Gallery\Utils\Constant;
use Gallery\Utils\Http\Json;

$scanner = new Scan(Constant::GALLERY);

Json::Response(array_map(function($value) {
    return $value . '.jpg';
}, $scanner->getGalleries()));

