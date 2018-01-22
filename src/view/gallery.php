<?php

use Utils\Json;
Use Utils\Scan;
use Utils\Constant;

Json::response(Scan::recursive(Constant::GALLERY . trim($_SERVER['REQUEST_URI'], '/') . '/thumbnails'));
