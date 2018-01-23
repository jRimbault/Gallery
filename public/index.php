<?php

require_once '../src/autoloader.php';

use Utils\Router;
use Utils\Constant;
use Utils\Scan;

$route = new Router();
$route->get('/', 'home');
$route->get('/portals', 'portal', 'POST');
$route->get('/assets/css/styles.css', 'styles.css');

$scanner = new Scan(Constant::GALLERY);

foreach ($scanner->getPortals() as $portal) {
    $route->get('/' . $portal, 'gallery', 'POST');
}

$route->notFound();
