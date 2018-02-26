<?php

namespace Gallery\Controller\Front;

use Conserto\Path;
use Conserto\Json;
use Conserto\Controller;
use Conserto\Server\Http\Request;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;


class Gallery extends Controller
{
    public static function page(Request $request)
    {
        $scanner = new Scan(Path::Gallery());
        $gallery = $request->server()->getRequest('uri');
        self::render('pages/gallery.html.twig', [
            'galleryName' => trim($gallery, '/'),
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
