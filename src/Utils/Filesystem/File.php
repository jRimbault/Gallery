<?php

namespace Gallery\Utils\Filesystem;


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

    /** Mostly stolen from a comment on the php manual */
    public static function rcopy($src, $dst)
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
