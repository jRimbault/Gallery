<?php

namespace Gallery\Controller\Back;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Config;
use Gallery\Controller\Error;
use Gallery\Utils\Http\Request;
use Gallery\Controller\Controller;


class Configuration extends Controller
{
    public static function form()
    {
        $conf = new Path('/config/app.json');
        if ($conf->fileExists() &&
            !Config::Instance()->getDev()) {
            Error::page(new Request());
        }
        self::render('pages/config.html.twig');
    }

    public static function config(Request $request)
    {
        $conf = [
            'site' => [
                'title' => $request->post()->get('title') ?? '',
                'about' => $request->post()->get('about') ?? '',
                'email' => $request->post()->get('email') ?? '',
            ],
            'color' => [
                'background' => $request->post()->get('background') ?? '',
                'lightbox' => $request->post()->get('lightbox') ?? '',
            ],
            'link' =>  $request->post()->get('link') ?? [],
            'switch' => [
                'dev' => ($request->post()->get('dev') == 'true'),
                'singlepage' => ($request->post()->get('singlepage') == 'true'),
                'theater' => true,
            ],
        ];
        Json::Response([
            'status' => Config::Write($conf),
            'received' => $_POST
        ]);
    }
}
