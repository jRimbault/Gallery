<?php

use Gallery\Utils\Http\Json;
use Gallery\Utils\Constant;
use Gallery\Utils\Filesystem\Scan;

$scanner = new Scan(Constant::GALLERY);

Json::Response($scanner->getGallery($this->getURI()));
