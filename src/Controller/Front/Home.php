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
    public function page()
    {
        $scanner = new Scan(new Path('/public/gallery'));
        return $this->render('pages/home.html.twig', [
            'galleries' => $scanner->getGalleries(),
        ]);
    }

    public function homeRedirect()
    {
        header('Location: /');
    }

    public function setFrench(Request $request)
    {
        $request->cookie()->set('language', 'fr-fr');
        $this->homeRedirect();
        }

    public function setEnglish(Request $request)
    {
        $request->cookie()->set('language', 'en-us');
        $this->homeRedirect();
    }

    public function setGerman(Request $request)
    {
        $request->cookie()->set('language', 'de-de');
        $this->homeRedirect();
    }

    public function setItalian(Request $request)
    {
        $request->cookie()->set('language', 'it-it');
        $this->homeRedirect();
    }
}
