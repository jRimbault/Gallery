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
        $this->add(
            'POST',
            $galleries,
            'Gallery\\Controller\\Front\\Gallery::gallery'
        );
        $this->add(
            'GET',
            $galleries,
            'Gallery\\Controller\\Front\\Gallery::page'
        );
    }

    private function setStaticGetRoutes()
    {
        $this->add(
            'GET',
            '/',
            'Gallery\\Controller\\Front\\Home::page'
        );
        $this->add(
            'GET',
            '/assets/css/styles.css',
            'Gallery\\Controller\\Front\\Assets::style'
        );
        $this->add(
            'GET',
            '/assets/js/main.js',
            'Gallery\\Controller\\Front\\Assets::js'
        );
        $this->add(
            'GET',
            '/configuration',
            'Gallery\\Controller\\Back\\Configuration::form'
        );
    }

    private function setStaticPostRoutes()
    {
        $this->add(
            'POST',
            '/galleries',
            'Gallery\\Controller\\Front\\Gallery::galleries'
        );
        $this->add(
            'POST',
            '/configuration',
            'Gallery\\Controller\\Back\\Configuration::config'
        );
    }
}
