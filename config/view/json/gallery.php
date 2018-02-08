<?php

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;
use Gallery\Utils\Filesystem\Scan;

$request = new Request();
$scanner = new Scan(Path::Gallery());

Json::Response($scanner->getGallery($request->server()->getRequest('uri')));
