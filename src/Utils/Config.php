<?php

namespace Gallery\Utils;

use Conserto\Path;
use Conserto\Json;


class Config extends \Conserto\Utils\Config
{
    /** Check configuration */
    public static function Check(array $conf): bool
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

    /**
     * Check if the given array has a subarray with the correct key
     * @param array  $conf  array of configuration settings
     * @param string $index key that must exist
     */
    private static function checkSubArray(array $conf, string $index): bool
    {
        if (!isset($conf[$index])) {
            return false;
        }
        if (gettype($conf[$index]) !== 'array') {
            return false;
        }
        return true;
    }

    /**
     * Given array should only contain strings
     * @param array $array
     */
    private static function checkArrayOfString(array $array): bool
    {
        foreach ($array as $i) {
            if (gettype($i) !== 'string') return false;
        }
        return true;
    }

    /**
     * Given array should only contain boolean
     * @param array $array
     */
    private static function checkArrayOfBoolean(array $array): bool
    {
        foreach ($array as $i) {
            if (gettype($i) !== 'boolean') return false;
        }
        return true;
    }
}
