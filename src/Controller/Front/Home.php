<?php

namespace Gallery\Controller\Front;

use Gallery\Path;
use Gallery\Utils\Config;
use Gallery\Controller\Controller;
use Gallery\Utils\Filesystem\Scan;


class Home extends Controller
{
    public static function page()
    {
        $scanner = new Scan(Path::Gallery());
        self::render('home.html.twig', [
            'conf' => Config::Instance(),
            'galleries' => $scanner->getGalleries(),
        ]);
    }
}
