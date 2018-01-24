<?php

namespace Utils\Filesystem;


class File
{
    public static function deleteFiles($target)
    {
        if (is_file($target)) {
            unlink($target);
        }
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK);
            foreach ($files as $file) {
                self::deleteFiles($file);
            }
            rmdir($target);
        }
    }
}
