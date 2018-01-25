<?php

namespace Gallery\Utils\Filesystem;

use Gallery\Path;


class File
{
    public static function deleteFiles($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK);
            foreach ($files as $file) {
                self::deleteFiles($file);
            }
            rmdir($target);
        } else if (is_file($target)) {
            unlink($target);
        }
    }

    public static function Deploy()
    {
        /** jQuery */
        $src = Path::Root() . '/vendor/components/jquery';
        $dst = Path::Root() . '/public/assets/lib/jquery';
        if (!self::rcopy($src, $dst)) {
            echo "Couldn't install Bootstrap properly";
        }
        /** Bootstrap */
        $src = Path::Root() . '/vendor/twbs/bootstrap/dist';
        $dst = Path::Root() . '/public/assets/lib/bootstrap';
        if (!self::rcopy($src, $dst)) {
            echo "Couldn't install Bootstrap properly";
        }
    }

    /** Stolen from a comment on the php manual */
    private static function rcopy($src, $dst)
    {
        // If source is not a directory stop processing
        if (!is_dir($src)) return false;

        // If the destination directory does not exist create it
        if (!is_dir($dst)) {
            if (!mkdir($dst)) {
                // If the destination directory could not be created stop processing
                return false;
            }
        }

        // Open the source directory to read in files
        $i = new \DirectoryIterator($src);
        foreach ($i as $f) {
            if ($f->isFile()) {
                copy($f->getRealPath(), "$dst/" . $f->getFilename());
            } else if (!$f->isDot() && $f->isDir()) {
                self::rcopy($f->getRealPath(), "$dst/$f");
            }
        }
        return true;
    }
}
