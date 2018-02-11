<?php

namespace Gallery\Controller\Back;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Config;
use Gallery\Utils\Http\Request;


class Configuration
{
    public static function form()
    {
        require new Path('/config/view/base/config.php');
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

        $conf['color']['background'] = self::removeHash($request->post()->get('background') ?? '');
        $conf['color']['lightbox'] = self::removeHash($request->post()->get('lightbox') ?? '');

        $conf['switch']['dev'] = ($request->post()->get('dev') == 'true');
        $conf['switch']['singlepage'] = ($request->post()->get('singlepage') == 'true');
        $conf['switch']['theater'] = true;

        $file = Path::Root() . '/config/app.json';

        if ($written = (!file_exists($file) && Config::Check($conf))) {
            Json::writeToFile($conf, $file);
        }

        Json::Response([
            'status' => $written,
            'conf' => $conf
        ]);
    }

    private static function removeHash(string $string)
    {
        return ltrim($string, '#');
    }
}
