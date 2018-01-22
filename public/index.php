<?php

require_once '../src/autoloader.php';

use Utils\Router;
use Utils\Constant;
use Utils\Scan;

$router = new Router();

$router->get('/', 'home');

$router->get('/assets/portal', 'portal');

$portals = Scan::getGalleryFolders(Constant::GALLERY);

foreach ($portals as $portal) {
    $router->get('/' . $portal, 'gallery');
}
