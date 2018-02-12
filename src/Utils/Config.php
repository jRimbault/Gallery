<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Json;


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
        $this->conf = Json::DecodeFile($filename);
    }

    /**
     * We want this class to be a singleton to keep the configuration
     * unique for the length of the program execution
     */
    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(new Path('/config/app.json'));
        }
        return self::$instance;
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
        return false;
    }

    /** Check configuration */
    public static function Check($conf)
    {
        if (!self::checkSubArray($conf, 'site')) { return false; }
        if (!self::checkSubArray($conf, 'color')) { return false; }
        if (!self::checkSubArray($conf, 'link')) { return false; }
        if (!self::checkSubArray($conf, 'switch')) { return false; }
        if (!self::checkArrayOfString($conf['site'])) { return false; }
        if (!self::checkArrayOfString($conf['color'])) { return false; }
        if (!self::checkArrayOfBoolean($conf['switch'])) { return false; }
        foreach($conf['link'] as $pair) {
            if (!self::checkArrayOfString($pair)) { return false; }
        }
        return true;
    }

    private static function checkSubArray($conf, $index)
    {
        if (!isset($conf[$index])) {
            return false;
        }
        if (gettype($conf[$index]) !== 'array') {
            return false;
        }
        return true;
    }

    private static function checkArrayOfString($array)
    {
        foreach ($array as $i) {
            if (gettype($i) !== 'string') return false;
        }
        return true;
    }

    private static function checkArrayOfBoolean($array)
    {
        foreach ($array as $i) {
            if (gettype($i) !== 'boolean') return false;
        }
        return true;
    }

}
