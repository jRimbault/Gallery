<?php

use Utils\Json;
use Utils\Scan;
use Utils\Constant;

Json::response(Scan::portals(Constant::GALLERY));
