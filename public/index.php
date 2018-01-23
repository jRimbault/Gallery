<?php

require_once '../src/autoloader.php';

use Utils\Router;
use Utils\Constant;
use Utils\Scan;

$route = new Router();
$route->get('/', 'home');
$route->get('/portals', 'portal');

$scanner = new Scan(Constant::GALLERY);

foreach ($scanner->getPortals() as $portal) {
    $route->get('/' . $portal, 'gallery');
}

$route->notFound();
