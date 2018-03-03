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
    public function page(Request $request)
    {
        $scanner = new Scan(new Path('/public/gallery'));
        $gallery = $request->server()->getRequest('uri');
        return $this->render('pages/gallery.html.twig', [
            'galleryName' => trim($gallery, '/'),
            'gallery'     => $scanner->getGallery($gallery),
        ]);
    }

    public function galleries()
    {
        $scanner = new Scan(new Path('/public/gallery'));
        return Json::Response(array_map(function($value) {
            return $value . '.jpg';
        }, $scanner->getGalleries()));
    }

    public function gallery(Request $request)
    {
        $scanner = new Scan(new Path('/public/gallery'));
        return Json::Response(
            $scanner->getGallery(
                $request->server()->getRequest('uri')
            )
        );
    }
}
