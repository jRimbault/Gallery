<?php

namespace Gallery\Controller\Front;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;
use Gallery\Utils\Filesystem\Scan;


class Gallery
{
    public static function page()
    {
        require new Path('/config/view/base/gallery.php');
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
