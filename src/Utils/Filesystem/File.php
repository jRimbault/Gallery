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
        $dst = Path::AssetsLib() . '/jquery';
        if (self::rcopy($src, $dst)) {
            echo "  jQuery deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install jQuery properly" . PHP_EOL;
        }
        /** Bootstrap */
        $src = Path::Root() . '/vendor/twbs/bootstrap/dist';
        $dst = Path::AssetsLib() . '/bootstrap';
        if (self::rcopy($src, $dst)) {
            echo "  Bootstrap deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install Bootstrap properly" . PHP_EOL;
        }
    }

    /** Mostly stolen from a comment on the php manual */
    private static function rcopy($src, $dst)
    {
        if (is_dir($src)) {
            @mkdir($dst, 0755, true);
            foreach (scandir($src) as $file) {
                if ($file != '.' && $file != '..') {
                    self::rcopy("$src/$file", "$dst/$file");
                }
            }
            return true;
        } else if (is_file($src)) {
            @copy($src, $dst);
            return true;
        }
        return false;
    }
}
