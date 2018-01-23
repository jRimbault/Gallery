<?php

require_once '../src/autoloader.php';

use Utils\Router;
use Utils\Constant;
use Utils\Scan;

$route = new Router();
$route->get('/', 'base/home');
$route->get('/portals', 'json/portal', 'POST');
$route->get('/assets/css/styles.css', 'assets/styles.css');

$scanner = new Scan(Constant::GALLERY);

foreach ($scanner->getPortals() as $portal) {
    $route->get('/' . $portal, 'json/gallery', 'POST');
}

$route->notFound();
