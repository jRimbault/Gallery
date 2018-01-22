<?php

use Utils\Json;
use Utils\Constant;
use Utils\Scan;

$scanner = new Scan(Constant::GALLERY);

Json::response($scanner->getGallery(trim($_SERVER['REQUEST_URI'], '/')));
