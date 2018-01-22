<?php

require_once '../src/autoloader.php';

use Utils\Config;
use Utils\Constant;
use Utils\Router;
use Utils\Scan;

$conf = new Config(Constant::CONFIG . 'app.ini');
$router = new Router();

$router->get('/', 'home');

$router->get('/assets/portal', 'portal');

$portals = Scan::getGalleryFolders(Constant::GALLERY);

foreach ($portals as $portal) {
    $router->get('/' . $portal, 'gallery');
}
