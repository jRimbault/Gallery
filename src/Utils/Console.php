<?php

namespace Gallery\Utils;

use Gallery\Utils\Filesystem\Thumbnail;

/**
 * Used by the bin/console script
 * This is currently only used to manage the galleries' thumbnails
 */
class Console
{
    private $option;

    private function help()
    {
?>
Script Name: console
Author: jRimbault

Description:
  Manage galleries' thumbnails

Usage: php bin/console option=<x>

Options:
  help        display this help
  makethumb   makes the thumbnails for all galleries
  deletethumb deletes all the existing thumbnails

Exemples:
  php bin/console makethumb
    makes all thumbnails
  php bin/console makethumb=holidays
    makes thumbnails for one particular gallery named "holidays"
  php bin/console deletethumb
    deletes all thumbnails
  php bin/console deletethumb=holidays
    deletes thumbnails for one particular gallery named "holidays"
<?php
    }

    /** Helper method to display errors to the user and log them */
    public static function error($input)
    {
        fwrite(STDERR, $input . PHP_EOL);
        error_log($input);
    }

    /** Helper method to display messages to the user */
    public static function message($input)
    {
        fwrite(STDOUT, $input . PHP_EOL);
    }

    /** Parses argv */
    private function setOptions($argv)
    {
        $this->option = [];
        foreach ($argv as $arg) {
            $e = explode('=', $arg);
            $this->option[strtolower($e[0])] = true;
            if (count($e) == 2) {
                $this->option[strtolower($e[0])] = $e[1];
            }
        }
    }

    /** Method to check if we're the correct environement */
    private function isCli()
    {
        return php_sapi_name() === 'cli';
    }

    /** Starts the CLI interface */
    public function __construct($argv)
    {
        if (!$this->isCli()) {
            self::error('This script must invoked from the command line');
            exit(1);
        }
        $this->setOptions($argv);
        if ($this->getHelp()) {
            $this->help();
        }
        if ($this->getMakeThumb()) {
            Thumbnail::makeThumbnails($this->getMakeThumb());
            die();
        }
        if ($this->getDeleteThumb()) {
            Thumbnail::deleteThumbnails($this->getDeleteThumb());
            die();
        }
        $this->help();
    }

    /**
     * Magic method to get the parsed options
     * Only accepts methods beginning by 'get'
     */
    public function __call($method, $params)
    {
        if (strncasecmp($method, 'get', 3) !== 0) return false;
        $var = strtolower(substr($method, 3));
        if (!isset($this->option[$var])) return false;

        return $this->option[$var];
    }
}
