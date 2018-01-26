<?php

namespace Gallery;

use Gallery\Utils\Config;


class Path
{
    public static function Root() { return dirname(__DIR__); }
    public static function Gallery() { return self::Root() . '/public/gallery'; }
    public static function View() { return self::Root() . '/config/view'; }
    public static function AssetsLib() { return self::Root() . '/public/assets/lib'; }
}
