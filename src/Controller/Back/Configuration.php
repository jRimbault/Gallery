<?php

namespace Gallery\Controller\Back;

use Gallery\Path;


class Configuration
{
    public static function form()
    {
        require new Path('/config/view/base/config.php');
    }

    public static function config()
    {
        require new Path('/config/view/json/config.php');
    }
}
