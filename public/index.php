<?php

use Gallery\Path;
use Gallery\Kernel;
use Gallery\Utils\Http\Request;


require_once '../vendor/autoload.php';


Path::setRoot(dirname(__DIR__));
new Kernel(new Request());
