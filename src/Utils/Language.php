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

    /**
     * This will not return an instance of the class Language
     * It returns an array of the strings used throughout the
     * application
     * The singleton mode of this class serves to be sure we
     * only read the language string file only one time
     * by instance.
     * @return array multidimensional array of indexed strings
     */
    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance->getStrings();
    }

    /**
     * If want to use as a normal class, you only need the constructor
     * and the getStrings method to be public
     */
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
