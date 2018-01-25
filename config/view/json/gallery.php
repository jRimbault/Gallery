<?php

use Gallery\Path;
use Gallery\Utils\Http\Json;
use Gallery\Utils\Filesystem\Scan;

$scanner = new Scan(Path::Gallery());

Json::Response($scanner->getGallery($this->getURI()));
