<?php

namespace Gallery\Controller\Front;

use Gallery\Path;


class Gallery
{
    public static function page()
    {
        require new Path('/config/view/base/gallery.php');
    }

    public static function galleries()
    {
        require new Path('/config/view/json/galleries.php');
    }

    public static function gallery()
    {
        require new Path('/config/view/json/gallery.php');
    }
}
