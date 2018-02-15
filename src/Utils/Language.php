<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;


class Language
{
    private $lang;
    private $request;
    private static $instance;

    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance->getStrings();
    }

    private function __construct()
    {
        $this->request = new Request();
        $this->lang = $this->getClientLanguage();
    }

    private function getLangFile()
    {
        $file = new Path("/config/lang/$this->lang.json");
        if (!$file->fileExists()) {
            $file->set("/config/lang/en-us.json");
        }
        return $file;
    }

    private function getStrings()
    {
        return Json::DecodeFile($this->getLangFile());
    }

    private function getClientPreferences(): array
    {
        $preferences = preg_split(
            '/(,|;)/',
            $this->request->server()->getHttp('accept_language')
        );
        return array_filter(array_map('strtolower', $preferences));
    }

    private function parseClientLanguage(): string
    {
        $preferences = $this->getClientPreferences();
        $file = new Path();
        foreach ($preferences as $lang) {
            $file->set("/config/lang/$lang.json");
            if ($file->fileExists()) return $lang;
            error_log("Missing language pack: $lang");
        }
        return 'en-us';
    }

    private function getClientLanguage(): string
    {
        if ($this->request->cookie()->get('language')) {
            return $this->request->cookie()->get('language');
        }
        return $this->parseClientLanguage();
    }
}
