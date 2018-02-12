<?php

namespace Gallery\Controller\Back;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Config;
use Gallery\Utils\Http\Request;
use Gallery\Controller\Controller;


class Configuration extends Controller
{
    public static function form()
    {
        $conf = Config::Instance();
        if (file_exists(Path::Root() . '/config/app.json') && !$conf->getDev()) {
            require_once new Path('/config/views/templates/error.html.php');
            die();
        }
        self::render('pages/config.html.twig', [
            'conf'        => Config::Instance()
        ]);
        require new Path('/config/views/pages/config.html.php');
    }

    public static function config(Request $request)
    {
        $conf = [
            'site' => [],
            'color' => [],
            'link' =>  $request->post()->get('link') ?? [],
            'switch' => [],
        ];

        $conf['site']['title'] = $request->post()->get('title') ?? '';
        $conf['site']['about'] = $request->post()->get('about') ?? '';
        $conf['site']['email'] = $request->post()->get('email') ?? '';

        $conf['color']['background'] = $request->post()->get('background') ?? '';
        $conf['color']['lightbox'] = $request->post()->get('lightbox') ?? '';

        $conf['switch']['dev'] = ($request->post()->get('dev') == 'true');
        $conf['switch']['singlepage'] = ($request->post()->get('singlepage') == 'true');
        $conf['switch']['theater'] = true;

        $path = new Path('/config/app.test.json');
        $file = $path->__toString();

        if ($written = (!file_exists($file) && Config::Check($conf))) {
            Json::writeToFile($conf, $file);
        }

        Json::Response([
            'status' => $written,
            'conf' => $conf
        ]);
    }
}
