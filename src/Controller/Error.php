<?php

namespace Gallery\Controller;

use Conserto\Path;
use Conserto\Json;
use Conserto\Server\Http\Request;
use Conserto\Controller;
use Gallery\Utils\Config;
use Gallery\Utils\Color;


class Error extends Controller
{
    public function page(Request $request)
    {
        return $this->notGet($request) ?? $this->htmlError($request);
    }

    public function htmlError(Request $request)
    {
        http_response_code(404);
        return $this->render('templates/error.html.twig', [
            'color' => $this->htmlTextColor()
        ]);
    }

    private function htmlTextColor(): string
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


    private function notGet(Request $request)
    {
        if ($request->server()->getRequest('method') !== 'GET') {
            return Json::Response([
                'status' => 404,
                'message' => 'Not found',
            ], 404);
        }
        return null;
    }
}
