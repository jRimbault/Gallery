<?php

ini_set('error_log', '../var/log/php_error.log');

require_once '../src/autoload.php';
require_once '../vendor/autoload.php';

use Utils\Http\Router;
use Utils\Constant;
use Utils\Filesystem\Scan;

$route = new Router();
$route->get('/', 'base/home');
$route->get('/galleries', 'json/galleries', 'POST');
$route->get('/assets/css/styles.css', 'assets/styles.css');
$route->get('/assets/js/main.js', 'assets/main.js');

$scanner = new Scan(Constant::GALLERY);

$route->get($scanner->getGalleries(), 'json/gallery', 'POST');

$route->notFound();
