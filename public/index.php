<?php

use Gallery\Kernel;


require_once '../vendor/autoload.php';


$app = new Kernel();

echo $app->start();
