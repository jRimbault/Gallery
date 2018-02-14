<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;


class Lang
{
    private static function getClientLanguage(): string
    {
        $request = new Request();
        if ($request->cookie()->get('language')) {
            return $request->cookie()->get('language');
        }
        return substr($request->server()->getHttp('accept_language'), 0, 2);
    }

    public static function Instance()
    {
        $lang = self::getClientLanguage();
        $langFile = new Path("/config/lang/$lang.json");
        if (!$langFile->fileExists()) {
            $langFile->set('/config/lang/en.json');
        }
        return Json::DecodeFile($langFile);
    }
}
