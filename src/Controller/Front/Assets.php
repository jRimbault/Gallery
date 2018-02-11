<?php

namespace Gallery\Controller\Front;

use Gallery\Path;
use Gallery\Utils\Color;
use Gallery\Utils\Config;


class Assets
{
    public static function style()
    {
        header('Content-Type: text/css');
        $conf = Config::Instance();
        $bg = self::defineColor($conf->getBackground());
        $lb = self::defineColor($conf->getLightbox());
        require new Path('/config/view/assets/styles.css.php');
    }

    public static function js()
    {
        header('Content-Type: application/javascript');
        require new Path('/config/view/assets/main.js.php');
    }

    private static function defineColor(string $input): Color
    {
        $color = new Color('#ffffff');
        if ($input) {
            try {
                $color = new Color($input);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
        return $color;
    }
}
