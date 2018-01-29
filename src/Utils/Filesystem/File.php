<?php

namespace Gallery\Utils\Filesystem;


class File
{
    public static function rremove($target)
    {
        if (is_dir($target)) {
            foreach (array_diff(scandir($target), ['.','..']) as $file) {
                self::rremove("$target/$file");
            }
            rmdir($target);
        } else if (is_file($target)) {
            unlink($target);
        }
    }

    /** Mostly stolen from a comment on the php manual */
    public static function rcopy($src, $dst)
    {
        if (is_dir($src)) {
            @mkdir($dst, 0755, true);
            foreach (array_diff(scandir($src), ['.','..']) as $file) {
                self::rcopy("$src/$file", "$dst/$file");
            }
            return true;
        } else if (is_file($src)) {
            @copy($src, $dst);
            return true;
        }
        return false;
    }
}
