<?php

namespace Gallery\Controller\Front;

use Gallery\Path;


class Assets
{
    public static function style()
    {
        require new Path('/config/view/assets/styles.css.php');
    }

    public static function js()
    {
        require new Path('/config/view/assets/main.js.php');
    }
}
