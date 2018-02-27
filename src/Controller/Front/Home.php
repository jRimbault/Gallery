<?php

namespace Gallery\Controller\Front;

use Conserto\Path;
use Conserto\Json;
use Conserto\Server\Http\Request;
use Conserto\Controller;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;


class Home extends Controller
{
    public static function page()
    {
        $scanner = new Scan(new Path('/public/gallery'));
        self::render('pages/home.html.twig', [
            'galleries' => $scanner->getGalleries(),
        ]);
    }

    public static function setFrench(Request $request)
    {
        $request->cookie()->set('language', 'fr-fr');
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => true,
                'message' => 'Language changed'
            ]);
        }
        self::page();
    }

    public static function setEnglish(Request $request)
    {
        $request->cookie()->set('language', 'en-us');
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => true,
                'message' => 'Language changed'
            ]);
        }
        self::page();
    }

    public static function setGerman(Request $request)
    {
        $request->cookie()->set('language', 'de-de');
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => true,
                'message' => 'Language changed'
            ]);
        }
        self::page();
    }

    public static function setItalian(Request $request)
    {
        $request->cookie()->set('language', 'it-it');
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => true,
                'message' => 'Language changed'
            ]);
        }
        self::page();
    }
}
