<?php

namespace Gallery;

use Conserto\Path;
use Conserto\Controller;
use Conserto\Utils\Language;
use Conserto\Server\Router;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;


ini_set('error_log', new Path('/var/log/php_error.log'));

/**
 * Used to define all the routes of the application
 */
class Kernel
{
    private $router;

    private function setConsertoConfiguration()
    {
        Language::setLanguageDir(new Path('/config/lang'));
        Config::setConfigFile(new Path('/config/app.json'));
        Controller::setCache(new Path('/var/cache'));
        Controller::setTemplate(new Path('/config/views'));
    }

    /**
     * That is the equivalent of 'main'
     */
    public function __construct()
    {
        $this->setConsertoConfiguration();
        $this->router = new Router();
        $this->setStaticRoutes();
        $this->setDynamicRoutes();
        $this->setLanguageRoutes();
        $this->router->start();
    }

    /** group together the static routes */
    private function setStaticRoutes()
    {
        $this->setStaticGetRoutes();
        $this->setStaticPostRoutes();
        $this->router->error('Gallery\\Controller\\Error::page');
    }

    /** group together the dynamic routes */
    private function setDynamicRoutes()
    {
        $scanner = new Scan(new Path('/public/gallery'));
        $galleries = array_map(function ($value) {
            return '/' . $value;
        }, $scanner->getGalleries());
        $this->router->add(
            $galleries, 'Gallery\\Controller\\Front\\Gallery::gallery', 'POST'
        );
        $this->router->add(
            $galleries, 'Gallery\\Controller\\Front\\Gallery::page', 'GET'
        );
    }

    /** static GET routes */
    private function setStaticGetRoutes()
    {
        $this->router->add(
            '/', 'Gallery\\Controller\\Front\\Home::page', 'GET'
        );
        $this->router->add(
            '/assets/css/styles.css', 'Gallery\\Controller\\Front\\Assets::style', 'GET'
        );
        $this->router->add(
            '/assets/js/main.js', 'Gallery\\Controller\\Front\\Assets::js', 'GET'
        );
        $this->router->add(
            '/configuration', 'Gallery\\Controller\\Back\\Configuration::form', 'GET'
        );
    }

    /** static POST routes */
    private function setStaticPostRoutes()
    {
        $this->router->add(
            '/galleries', 'Gallery\\Controller\\Front\\Gallery::galleries', 'POST'
        );
        $this->router->add(
            '/configuration', 'Gallery\\Controller\\Back\\Configuration::config', 'POST'
        );
    }

    /** routes used by the user to choose a language */
    private function setLanguageRoutes()
    {
        $this->router->add(
            '/fr', 'Gallery\\Controller\\Front\\Home::setFrench', ['GET', 'POST']
        );
        $this->router->add(
            '/en', 'Gallery\\Controller\\Front\\Home::setEnglish', ['GET', 'POST']
        );
        $this->router->add(
            '/de', 'Gallery\\Controller\\Front\\Home::setGerman', ['GET', 'POST']
        );
        $this->router->add(
            '/it', 'Gallery\\Controller\\Front\\Home::setItalian', ['GET', 'POST']
        );
    }
}
