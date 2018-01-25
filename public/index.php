<?php

ini_set('error_log', '../var/log/php_error.log');

require_once '../vendor/autoload.php';

use Gallery\Path;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Utils\Http\Router;


$route = new Router();
$route->get('/', 'base/home');
$route->get('/galleries', 'json/galleries', 'POST');
$route->get('/assets/css/styles.css', 'assets/styles.css');
$route->get('/assets/js/main.js', 'assets/main.js');

$scanner = new Scan(Path::Gallery());

$route->get($scanner->getGalleries(), 'json/gallery', 'POST');

$route->notFound('/error/404');
