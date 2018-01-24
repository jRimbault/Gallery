<?php

namespace Utils\Filesystem;

use Utils\Constant;


class Thumbnail
{
    private $gallery;
    private $image;

    public function __construct($gallery, $image)
    {
        $this->gallery = $gallery;
        $this->image = $image;
    }

    public function make($width = 320, $height = 240)
    {
        $path = $this->thumbnailPath();
        if (is_file($path)) return false;
        try {
            $thumbnail = new \Imagick($this->imagePath());
            $thumbnail->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1);
            $thumbnail->writeImage($path);
            $thumbnail->destroy();
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    private function imagePath()
    {
        return $this->galleryPath() . $this->image;
    }

    private function thumbnailPath()
    {
        $path = $this->galleryPath() . 'thumbnails' . DIRECTORY_SEPARATOR;
        if (!file_exists($path)) mkdir($path, 0755);
        return $path . $this->image;
    }

    private function galleryPath()
    {
        return Constant::GALLERY . $this->gallery . DIRECTORY_SEPARATOR;
    }
}
