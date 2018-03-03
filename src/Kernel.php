<?php

namespace Gallery;

use Conserto\Path;
use Conserto\Controller;
use Conserto\Server\Router;
use Conserto\Utils\Language;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Controller\Error;
use Gallery\Controller\Front\Home;
use Gallery\Controller\Front\Assets;
use Gallery\Controller\Front\Gallery;
use Gallery\Controller\Back\Configuration;


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
    }

    public function start()
    {
        return $this->router->start();
    }

    /** group together the static routes */
    private function setStaticRoutes()
    {
        $this->setStaticGetRoutes();
        $this->setStaticPostRoutes();
        $this->router->error(Error::class, 'page');
    }

    /** group together the dynamic routes */
    private function setDynamicRoutes()
    {
        $scanner = new Scan(new Path('/public/gallery'));

        $galleries = array_map(function ($value) {
            return '/' . $value;
        }, $scanner->getGalleries());

        foreach ($galleries as $gallery) {
            $this->router->add($gallery, Gallery::class, 'gallery', 'POST');
            $this->router->add($gallery, Gallery::class, 'page');
        }
    }

    /** static GET routes */
    private function setStaticGetRoutes()
    {
        $this->router->add('/', Home::class, 'page');
        $this->router->add('/assets/css/styles.css', Assets::class, 'style');
        $this->router->add('/assets/js/main.js', Assets::class, 'js');
        $this->router->add('/configuration', Configuration::class, 'form');
    }

    /** static POST routes */
    private function setStaticPostRoutes()
    {
        $this->router->add('/galleries', Gallery::class, 'galleries', 'POST');
        $this->router->add('/configuration', Configuration::class, 'config', 'POST');
    }

    /** routes used by the user to choose a language */
    private function setLanguageRoutes()
    {
        $this->router->add('/fr', Home::class, 'setFrench');
        $this->router->add('/en', Home::class, 'setEnglish');
        $this->router->add('/de', Home::class, 'setGerman');
        $this->router->add('/it', Home::class, 'setItalian');
    }
}
