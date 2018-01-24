<?php

namespace Utils;

use Utils\Filesystem\Thumbnail;


class Console
{
    private $option;

    public static function error($input)
    {
        fwrite(STDERR, $input . PHP_EOL);
        error_log($input);
    }

    public static function message($input)
    {
        fwrite(STDOUT, $input . PHP_EOL);
    }

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

    private function isCli()
    {
        return php_sapi_name() === 'cli';
    }

    public function __construct($argv)
    {
        if (!$this->isCli()) {
            self::error('This script must invoked from the command line');
            exit(1);
        }
        $this->setOptions($argv);
        if ($this->getMakeThumb()) {
            Thumbnail::makeThumbnails();
        }
        if ($this->getDeleteThumb()) {
            Thumbnail::deleteThumbnails();
        }
    }

    public function __call($method, $params)
    {
        if (strncasecmp($method, 'get', 3) !== 0) return false;
        $var = strtolower(substr($method, 3));
        if (!isset($this->option[$var])) return false;

        return $this->option[$var];
    }
}
