<?php

namespace Utils\Filesystem;

use Utils\Constant;


class Thumbnail
{
    private $galleryPath;
    private $galleryName;
    private $image;
    private $thumbnail;

    public function __construct($gallery, $image) {
        $this->gallery = $gallery;
        $this->image = $image;
        try {
            $this->thumbnail = new \Imagick(Constant::GALLERY . $gallery . DIRECTORY_SEPARATOR . $image);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function make($width = 320, $height = 240)
    {
        $path = Constant::GALLERY . $this->gallery .
                DIRECTORY_SEPARATOR . 'thumbnails' .
                DIRECTORY_SEPARATOR . $this->image;

        if (is_file($path)) { return false; }

        $this->thumbnail->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
        $this->thumbnail->writeImage($path);
        $this->thumbnail->destroy();

        return true;
    }
}
