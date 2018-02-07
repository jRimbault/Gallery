<?php

ini_set('error_log', '../var/log/php_error.log');

require_once '../vendor/autoload.php';

use Gallery\Path;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Utils\Http\Router;

$router = new Router();

$router->add('/', 'base/home');
$router->add('/about', 'base/about');
$router->add('/galleries', 'json/galleries', 'POST');
$router->add('/assets/css/styles.css', 'assets/styles.css');
$router->add('/assets/js/main.js', 'assets/main.js');

$scanner = new Scan(Path::Gallery());
$galleries = $scanner->getGalleries();

$router->add($galleries, 'json/gallery', 'POST');
$router->add($galleries, 'base/gallery', 'GET');

$router->add('/configuration', 'base/config');
$router->add('/configuration', 'json/config', 'POST');

$router->start();
