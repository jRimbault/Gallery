<?php

require_once '../src/autoloader.php';

Json::response(Scan::portals(Constant::GALLERY));
