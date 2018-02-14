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
        $this->setLanguageRoutes();
        $this->start();
    }

    private function setStaticRoutes()
    {
        $this->setStaticGetRoutes();
        $this->setStaticPostRoutes();
        $this->error('Gallery\\Controller\\Error::page');
    }

    private function setDynamicRoutes()
    {
        $scanner = new Scan(Path::Gallery());
        $galleries = $scanner->getGalleries();
        $this->add(
            $galleries, 'Gallery\\Controller\\Front\\Gallery::gallery', 'POST'
        );
        $this->add(
            $galleries, 'Gallery\\Controller\\Front\\Gallery::page', 'GET'
        );
    }

    private function setStaticGetRoutes()
    {
        $this->add(
            '/', 'Gallery\\Controller\\Front\\Home::page', 'GET'
        );
        $this->add(
            '/assets/css/styles.css', 'Gallery\\Controller\\Front\\Assets::style', 'GET'
        );
        $this->add(
            '/assets/js/main.js', 'Gallery\\Controller\\Front\\Assets::js', 'GET'
        );
        $this->add(
            '/configuration', 'Gallery\\Controller\\Back\\Configuration::form', 'GET'
        );
    }

    private function setStaticPostRoutes()
    {
        $this->add(
            '/galleries', 'Gallery\\Controller\\Front\\Gallery::galleries', 'POST'
        );
        $this->add(
            '/configuration', 'Gallery\\Controller\\Back\\Configuration::config', 'POST'
        );
    }

    private function setLanguageRoutes()
    {
        $this->add(
            '/fr', 'Gallery\\Controller\\Front\\Home::setFrench', ['GET', 'POST']
        );
        $this->add(
            '/en', 'Gallery\\Controller\\Front\\Home::setEnglish', ['GET', 'POST']
        );
    }
}
