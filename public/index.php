<?php

require_once '../src/autoloader.php';

use Utils\Http\Router;
use Utils\Constant;
use Utils\Filesystem\Scan;

$route = new Router();
$route->get('/', 'base/home');
$route->get('/galleries', 'json/galleries', 'POST');
$route->get('/assets/css/styles.css', 'assets/styles.css');

$scanner = new Scan(Constant::GALLERY);

$route->get($scanner->getGalleries(), 'json/gallery', 'POST');

$route->notFound();
