<?php

use Utils\Http\Json;
use Utils\Constant;
use Utils\Filesystem\Scan;

$scanner = new Scan(Constant::GALLERY);

Json::Response($scanner->getGallery($this->getURI()));
