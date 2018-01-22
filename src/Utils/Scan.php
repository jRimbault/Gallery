<?php

namespace Utils;


class Scan
{
    private $dir;
    private static $excluded = [
        '.',
        '..',
        '.gitkeep',
        'thumbnails',
    ];

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    private function filterPortal($value)
    {
        if (in_array($value, self::$excluded)) return false;
        if (strpos($value, '.') !== false) return false;
        return true;
    }

    private function filterGallery($value)
    {
        if (in_array($value, self::$excluded)) return false;
        return true;
    }

    public function getPortals()
    {
        return array_values(
            array_filter(scandir($this->dir), 'self::filterPortal')
        );
    }

    public function getGallery($portal)
    {
        return array_values(
            array_filter(scandir($this->dir . $portal), 'self::filterGallery')
        );
    }
}
