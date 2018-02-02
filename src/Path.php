<?php

namespace Gallery;


class Path
{
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
