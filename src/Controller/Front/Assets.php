<?php

namespace Gallery\Controller\Front;

use Conserto\Path;
use Conserto\Controller;
use Gallery\Utils\Config;
use Gallery\Utils\Color;


class Assets extends Controller
{
    public static function style()
    {
        header('Content-Type: text/css');
        require new Path('/config/views/assets/styles.css');
        $conf = Config::Instance();
        $bg = self::defineColor($conf->getBackground());
        $lb = self::defineColor($conf->getLightbox());
        echo self::backgroundColorRule('.bg-dark', $bg->__toString());
        echo self::backgroundColorRule('.ekko-lightbox .modal-content', $lb->__toString());
        if ($bg->getLightness() > 200) {
            echo self::textColorRule('ul li a.text-white', '#000000');
            echo self::textColorRule('.navbar .navbar-brand', '#000000');
            echo self::backgroundColorRule('.navbar-dark .navbar-toggler', '#c4c4c4');
        }
    }

    public static function js()
    {
        header('Content-Type: application/javascript');
        self::render('assets/main.js.twig');
    }

    private static function defineColor(string $input): Color
    {
        $color = new Color('#ffffff');
        if ($input) {
            try {
                $color = new Color($input);
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }
        return $color;
    }

    private static function backgroundColorRule(string $selector, string $color): string
    {
        return "$selector { background-color: $color !important; }" . PHP_EOL;
    }

    private static function textColorRule(string $selector, string $color): string
    {
        return "$selector { color: $color !important; }" . PHP_EOL;
    }
}
