<?php

namespace Gallery\Utils;

use Gallery\Path;


class Config
{
    private $conf;
    private static $instance;

    private function __construct($filename)
    {
        $this->conf = parse_ini_file($filename, true);
        $this->setLinks();
    }

    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(Path::Root() . '/config/app.ini');
        }
        return self::$instance;
    }

    private function setLinks()
    {
        if (!isset($this->conf['LINK']['url'])) return;
        $links = [];
        for ($i = 0; $i < count($this->conf['LINK']['url']); $i += 1) {
            $links[$i]['url'] = $this->conf['LINK']['url'][$i];
            $links[$i]['text'] = $this->conf['LINK']['text'][$i] ?? $this->conf['LINK']['url'][$i];
        }
        unset($this->conf['LINK']);
        $this->conf['LINK'] = $links;
    }

    private function search($needle, $array, $params = -1)
    {
        if (!is_array($array)) return false;
        $array = array_change_key_case($array, CASE_LOWER);
        if (isset($array[$needle])) return $array[$needle];
        foreach ($array as $item) {
            $ret = $this->search($needle, $item, $params);
            if ($ret) return $ret;
        }
        return false;
    }

    public function __call($method, $params = [])
    {
        $arg = $params[0] ?? -1;
        $var = strtolower(substr($method, 3));
        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->search($var, $this->conf, $arg);
        }
    }
}
