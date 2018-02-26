<?php

namespace Gallery\Utils\Filesystem;

use Imagick;
use Conserto\Path;
use Gallery\Utils\Console;
use Gallery\Utils\Filesystem\File;

/**
 * Generates a thumbnail out of a source image
 */
class Thumbnail
{
    private $gallery;
    private $image;

    /**
     * @param string $gallery the path where the image is located
     */
    private function __construct(string $gallery, string $image)
    {
        $this->gallery = $gallery;
        $this->image = $image;
    }

    /**
     * Generates thumbnail using Imagemagick's php extension Imagick
     */
    private function make(int $width = 640, int $height = 480)
    {
        $path = $this->thumbnailPath();
        if (is_file($path)) return false;
        try {
            $thumbnail = new Imagick($this->imagePath());
            $thumbnail->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
            $thumbnail->writeImage($path);
            $thumbnail->destroy();
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    private function imagePath()
    {
        return join(DIRECTORY_SEPARATOR, [
            $this->galleryPath(),
            $this->image
        ]);
    }

    private function thumbnailPath()
    {
        $path = join(DIRECTORY_SEPARATOR, [
            $this->galleryPath(),
            'thumbnails'
        ]);
        if (!file_exists($path)) {
            mkdir($path, 0755);
        }
        return join(DIRECTORY_SEPARATOR, [
            $path,
            $this->image
        ]);
    }

    private function galleryPath()
    {
        return join(DIRECTORY_SEPARATOR, [
            Path::Gallery(),
            $this->gallery,
        ]);
    }

    public static function makeThumbnails($gallery = true)
    {
        $scanner = new Scan(Path::Gallery());
        Console::message('Scanning the galleries...');
        if ($gallery !== true) {
            self::makeThumbnailsOf($gallery, $scanner);
        } else {
            foreach ($scanner->getGalleries() as $gallery) {
                self::makeThumbnailsOf($gallery, $scanner);
            }
        }
    }

    private static function makeThumbnailsOf(string $gallery, Scan $scanner)
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
        $scanner = new Scan(Path::Gallery());
        if ($gallery !== true) {
            self::deleteThumbnailsOf($gallery, $scanner);
        } else {
            foreach ($scanner->getGalleries() as $gallery) {
                self::deleteThumbnailsOf($gallery, $scanner);
            }
        }
    }

    private static function deleteThumbnailsOf(string $gallery, Scan $scanner)
    {
        foreach ($scanner->getGallery($gallery) as $image) {
            $path = join(DIRECTORY_SEPARATOR, [
                Path::Gallery(),
                $gallery,
                'thumbnails'
            ]);
            File::rremove($path);
        }
    }

    private static function galleryState(string $gallery, Scan $scanner)
    {
        $msg = '- ' . ucfirst($gallery);
        $msg .= ' (' . count($scanner->getGallery($gallery)) . ')';
        Console::message($msg);
    }
}
