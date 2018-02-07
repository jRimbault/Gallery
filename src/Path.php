<?php

namespace Gallery;


class Path
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    public function __toString() { return self::Root() . $this->path; }

    public static function Root() { return dirname(__DIR__); }

    /** Shortcut to the gallery directory */
    public static function Gallery() {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'gallery',
        ]);
    }

    /** Shortcut to the base view directory */
    public static function View() {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'config',
            'view',
        ]);
    }

    /** Shortcut to the front-end libraries directory */
    public static function AssetsLib() {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'assets',
            'lib',
        ]);
    }
}
