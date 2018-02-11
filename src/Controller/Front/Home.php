<?php

namespace Gallery\Controller\Front;

use Gallery\Path;


class Home
{
    public static function page()
    {
        require new Path('/config/view/base/home.php');
    }
}
