<?php

namespace Gallery;

use Gallery\Path;
use Gallery\Utils\Http\Router;
use Gallery\Utils\Filesystem\Scan;


ini_set('error_log', new Path('/var/log/php_error.log'));


class Kernel extends Router
{
    /** main */
    public function __construct()
    {
        parent::__construct();
        $this->setStaticRoutes();
        $this->setDynamicRoutes();
        $this->start();
    }

    private function setStaticRoutes()
    {
        $this->setStaticGetRoutes();
        $this->setStaticPostRoutes();
    }

    private function setDynamicRoutes()
    {
        $scanner = new Scan(Path::Gallery());
        $galleries = $scanner->getGalleries();
        $this->add($galleries, 'json/gallery', 'POST');
        $this->add($galleries, 'base/gallery', 'GET');
    }

    private function setStaticGetRoutes()
    {
        $this->add('/', 'base/home');
        $this->add('/about', 'base/about');
        $this->add('/assets/css/styles.css', 'assets/styles.css');
        $this->add('/assets/js/main.js', 'assets/main.js');
        $this->add('/configuration', 'base/config');
    }

    private function setStaticPostRoutes()
    {
        $this->add('/galleries', 'json/galleries', 'POST');
        $this->add('/configuration', 'json/config', 'POST');
    }
}
