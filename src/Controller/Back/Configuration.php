<?php

namespace Gallery\Controller\Back;

use Conserto\Path;
use Conserto\Json;
use Conserto\Server\Http\Request;
use Conserto\Controller;
use Gallery\Utils\Config;
use Gallery\Controller\Error;


class Configuration extends Controller
{
    public function form(Request $request)
    {
        $conf = new Path('/config/app.json');
        if ($conf->fileExists() &&
            !Config::Instance()->getDev())
        {
            return (new Error())->page($request);
        }
        return $this->render('pages/config.html.twig');
    }

    public function config(Request $request)
    {
        return Json::Response([
            'status' => Config::Write([
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
            ]),
            'received' => $_POST
        ]);
    }
}
