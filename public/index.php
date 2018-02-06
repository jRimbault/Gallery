<?php

ini_set('error_log', '../var/log/php_error.log');

require_once '../vendor/autoload.php';

use Gallery\Path;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Utils\Http\Router;

$route = new Router();

$route->add('/', 'base/home');
$route->add('/about', 'base/about');
$route->add('/galleries', 'json/galleries', 'POST');
$route->add('/assets/css/styles.css', 'assets/styles.css');
$route->add('/assets/js/main.js', 'assets/main.js');

$scanner = new Scan(Path::Gallery());

$route->add($scanner->getGalleries(), 'json/gallery', 'POST');
$route->add($scanner->getGalleries(), 'base/gallery', 'GET');

$route->add('/configuration', 'base/config');
$route->add('/configuration', 'json/config', 'POST');

$route->notFound('/error/404');
