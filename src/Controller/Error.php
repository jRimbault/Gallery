<?php

namespace Gallery\Controller;

use Conserto\Path;
use Conserto\Json;
use Gallery\Utils\Color;
use Gallery\Utils\Config;
use Conserto\Server\Http\Request;
use Gallery\Controller\Controller;


class Error extends Controller
{
    public static function page(Request $request)
    {
        self::notGet($request);
        self::htmlError($request);
        die();
    }

    private static function htmlError(Request $request)
    {
        http_response_code(404);
        self::render('templates/error.html.twig', [
            'color' => self::htmlTextColor()
        ]);
    }

    private static function htmlTextColor(): string
    {
        $conf = Config::Instance();
        $bg = new Color('#ffffff');
        $color = '#000000';
        if ($conf->getBackground()) {
            try {
                $bg = new Color($conf->getBackground());
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }
        if ($bg->getLightness() < 200) {
            $color = '#ffffff';
        }
        return $color;
    }


    private static function notGet(Request $request)
    {
        if ($request->server()->getRequest('method') !== 'GET') {
            Json::Response([
                'status' => 404,
                'message' => 'Not found',
            ], 404);
        }
    }
}
