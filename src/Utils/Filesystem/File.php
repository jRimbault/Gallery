<?php

namespace Gallery\Utils\Filesystem;

/**
 * Used conjointly the two methods here allow for easier file management
 * inside the program
 */
class File
{
    /**
     * Recursively remove a directory and its children
     * from the filesystem
     */
    public static function rremove(string $target)
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

    /**
     * Recursively copy a directory and its children
     * from one point to another
     */
    public static function rcopy(string $src, string $dst)
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
