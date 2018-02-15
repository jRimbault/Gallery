<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;


class Lang
{
    public static function Instance()
    {
        $lang = self::getClientLanguage();
        $langFile = new Path("/config/lang/$lang.json");
        return Json::DecodeFile($langFile);
    }

    private static function getClientPreferences(): array
    {
        $request = new Request();
        return preg_split(
            '/(,|;)/',
            $request->server()->getHttp('accept_language')
        );
    }

    private static function parseClientLanguage(): string
    {
        $preferredLangs = array_map('strtolower', self::getClientPreferences());
        $file = new Path();
        foreach ($preferredLangs as $lang) {
            $file->set("/config/lang/$lang.json");
            if ($file->fileExists()) return $lang;
            error_log("Missing language pack: $lang");
        }
        return 'en-us';
    }

    private static function getClientLanguage(): string
    {
        $request = new Request();
        if ($request->cookie()->get('language')) {
            return $request->cookie()->get('language');
        }
        return self::parseClientLanguage();
    }
}
