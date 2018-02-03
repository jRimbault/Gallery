<?php

namespace Gallery\Utils;

use Gallery\Path;

/**
 * This class is responsible for loading a configuration file,
 * keeping it in memory, and making it *readable* from everywhere
 */
class Config
{
    private $conf;
    private static $instance;

    private function __construct(string $filename)
    {
        $this->conf = parse_ini_file($filename, true);
        $this->setLinks();
    }

    /**
     * We want this class to be a singleton to keep the configuration
     * unique for the length of the program execution
     */
    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(Path::Root() . '/config/app.ini');
        }
        return self::$instance;
    }

    /**
     * Currently we're loading an ini file as configuration file.
     * INI syntax doesn't really have double nested lists
     * We're using a trick to set the PHP array straight,
     * before we're using it.
     *
     * @todo replace the .ini by .json or .xml
     *       and on first run present a form
     *       to the first user to fill out
     *       a configuration
     */
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

    /**
     * Used by the magic getter method
     * Recursive method
     */
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

    /** Magic getter method */
    public function __call($method, $params = [])
    {
        $arg = $params[0] ?? -1;
        $var = strtolower(substr($method, 3));
        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->search($var, $this->conf, $arg);
        }
    }
}
