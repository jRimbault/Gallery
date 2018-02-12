<?php

namespace Gallery\Controller\Front;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Config;
use Gallery\Utils\Http\Request;
use Gallery\Utils\Filesystem\Scan;
use Gallery\Controller\Controller;


class Gallery extends Controller
{
    public static function page(Request $request)
    {
        $scanner = new Scan(Path::Gallery());
        $gallery = $request->server()->getRequest('uri');
        self::render('gallery.html.twig', [
            'conf'        => Config::Instance(),
            'galleryName' => $gallery,
            'gallery'     => $scanner->getGallery($gallery),
        ]);
    }

    public static function galleries()
    {
        $scanner = new Scan(Path::Gallery());
        Json::Response(array_map(function($value) {
            return $value . '.jpg';
        }, $scanner->getGalleries()));
    }

    public static function gallery(Request $request)
    {
        $scanner = new Scan(Path::Gallery());
        Json::Response(
            $scanner->getGallery(
                $request->server()->getRequest('uri')
            )
        );
    }
}
