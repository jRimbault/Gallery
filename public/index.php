<?php

use Gallery\Kernel;
use Conserto\Server\Http\Request;


require_once '../vendor/autoload.php';


new Kernel(new Request());
