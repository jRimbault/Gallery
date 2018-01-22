<?php

require_once '../src/autoloader.php';

use Utils\Router;
use Utils\Constant;
use Utils\Scan;

$router = new Router();

$router->get('/', 'home');

$router->get('/portals', 'portal');

$scanner = new Scan(Constant::GALLERY);

foreach ($scanner->getPortals() as $portal) {
    $router->get('/' . $portal, 'gallery');
}
