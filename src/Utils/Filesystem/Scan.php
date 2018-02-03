<?php

namespace Gallery\Utils\Filesystem;


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

    /**
     * Galleries should not have a dot in their name
     * The dot is used to git rid of extraneous files
     * like the .jpg files used to characterize the galleries
     */
    private function filterGalleriesName($value)
    {
        if (in_array($value, self::$excluded)) return false;
        if (strpos($value, '.') !== false) return false;
        return true;
    }

    /** We only want the images in a directory */
    private function filterGallery($value)
    {
        if (in_array($value, self::$excluded)) return false;
        return true;
    }

    public function getGalleries()
    {
        return array_values(
            array_filter(scandir($this->dir), 'self::filterGalleriesName')
        );
    }

    public function getGallery($portal)
    {
        $dir = join(DIRECTORY_SEPARATOR, [$this->dir, $portal]);
        return array_values(
            array_filter(scandir($dir), 'self::filterGallery')
        );
    }
}
