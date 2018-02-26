<?php

namespace Gallery\Controller;

use Conserto\Path;
use Twig_Environment;
use Gallery\Utils\Language;
use Gallery\Utils\Config;
use Twig_Loader_Filesystem;


class Controller
{
    protected static function render(string $file, array $params = [])
    {
        $conf = Config::Instance();
        $templates = new Path('/config/views');
        $cache = new Path('/var/cache');
        $options = [
            'debug' => $conf->getDev(),
            'cache' => $conf->getDev() ? false : $cache->get()
        ];
        $loader = new Twig_Loader_Filesystem($templates->get());
        $twig = new Twig_Environment($loader, $options);
        $clientReturn = '';
        $params['strings'] = Language::Instance();
        $params['conf'] = Config::Instance();
        try {
            $clientReturn = $twig->render($file, $params);
        } catch (\Twig_Error_Loader $e) {
            error_log($e->getMessage());
        } catch (\Twig_Error_Runtime $e) {
            error_log($e->getMessage());
        } catch (\Twig_Error_Syntax $e) {
            error_log($e->getMessage());
        }
        die($clientReturn);
    }
}
