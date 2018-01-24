<?php

namespace Utils\Filesystem;

use Utils\Constant;
use Utils\Console;
use Utils\Filesystem\File;


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
            $thumbnail->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
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

    public static function makeThumbnails($gallery = true)
    {
        $scanner = new Scan(Constant::GALLERY);
        Console::message('Scanning the galleries...');
        if ($gallery !== true) {
            self::makeThumbnailsOf($gallery, $scanner);
        } else {
            foreach ($scanner->getGalleries() as $gallery) {
                self::makeThumbnailsOf($gallery, $scanner);
            }
        }
    }

    private static function makeThumbnailsOf($gallery, $scanner)
    {
        $counter = 0;
        self::galleryState($gallery, $scanner);
        foreach ($scanner->getGallery($gallery) as $image) {
            $thumb = new Thumbnail($gallery, $image);
            try {
                if ($thumb->make()) {
                    $counter += 1;
                }
            } catch (\Exception $e) {
                Console::error($e->getMessage());
            }
        }
        Console::message("  $counter thumbnails generated");
    }

    public static function deleteThumbnails($gallery = true)
    {
        $scanner = new Scan(Constant::GALLERY);
        if ($gallery !== true) {
            self::deleteThumbnailsOf($gallery, $scanner);
        } else {
            foreach ($scanner->getGalleries() as $gallery) {
                self::deleteThumbnailsOf($gallery, $scanner);
            }
        }
    }

    private static function deleteThumbnailsOf($gallery, $scanner)
    {
        foreach ($scanner->getGallery($gallery) as $image) {
            $path = Constant::GALLERY . $gallery . DIRECTORY_SEPARATOR . 'thumbnails';
            File::deleteFiles($path);
        }
    }

    private static function galleryState($gallery, $scanner)
    {
        $msg = '- ' . ucfirst($gallery);
        $msg .= ' (' . count($scanner->getGallery($gallery)) . ')';
        Console::message($msg);
    }
}
