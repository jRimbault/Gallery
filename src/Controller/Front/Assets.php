<?php

namespace Gallery\Controller\Front;

use Conserto\Path;
use Conserto\Controller;
use Gallery\Utils\Config;
use Gallery\Utils\Color;


class Assets extends Controller
{
    public function style()
    {
        header('Content-Type: text/css');
        $conf = Config::Instance();
        $bg = self::defineColor($conf->getBackground());
        $lb = self::defineColor($conf->getLightbox());
        $css[] = file_get_contents(new Path('/config/views/assets/styles.css'));
        $css[] = self::backgroundColorRule('.bg-dark', $bg->__toString());
        $css[] = self::backgroundColorRule('.ekko-lightbox .modal-content', $lb->__toString());
        if ($bg->getLightness() > 200) {
            $css[] = self::textColorRule('ul li a.text-white', '#000000');
            $css[] = self::textColorRule('.navbar .navbar-brand', '#000000');
            $css[] = self::backgroundColorRule('.navbar-dark .navbar-toggler', '#c4c4c4');
        }
        return join(PHP_EOL, $css);
    }

    public function js()
    {
        header('Content-Type: application/javascript');
        return $this->render('assets/main.twig.js');
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
        return "$selector { background-color: $color !important; }";
    }

    private static function textColorRule(string $selector, string $color): string
    {
        return "$selector { color: $color !important; }";
    }
}
