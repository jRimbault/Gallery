<?php

namespace Gallery\Controller\Front;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Config;
use Gallery\Utils\Http\Request;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Controller\Controller;


class Home extends Controller
{
    public static function page()
    {
        $scanner = new Scan(Path::Gallery());
        self::render('pages/home.html.twig', [
            'galleries' => $scanner->getGalleries(),
        ]);
    }

    public static function setFrench(Request $request)
    {
        $request->cookie()->set('language', 'fr-FR');
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
        $request->cookie()->set('language', 'en-US');
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
        $request->cookie()->set('language', 'de-DE');
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
        $request->cookie()->set('language', 'it-IT');
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => true,
                'message' => 'Language changed'
            ]);
        }
        self::page();
    }
}
