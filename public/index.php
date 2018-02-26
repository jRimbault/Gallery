<?php

use Gallery\Kernel;
use Conserto\Path;
use Conserto\Server\Http\Request;


require_once '../vendor/autoload.php';


Path::setRoot(dirname(__DIR__));
new Kernel(new Request());
