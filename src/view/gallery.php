<?php

require_once '../src/autoloader.php';

Json::response(Scan::recursive(Constant::GALLERY . trim($_SERVER['REQUEST_URI'], '/') . '/thumbnails'));
