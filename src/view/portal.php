<?php

use Utils\Json;
use Utils\Scan;
use Utils\Constant;

$scanner = new Scan(Constant::GALLERY);

Json::response(array_map(function($value) {
    return $value . '.jpg';
}, $scanner->getPortals()));

