<?php

//namespace App\Utils;


class Scan
{
    public static function getGalleryFolders($dir)
    {
        $array = scandir($dir);
        return array_filter($array, 'self::filterArrayForThumbnails');
    }

    public static function filterArrayForThumbnails($value)
    {
        $excluded = [
            '.',
            '..',
            '.gitkeep',
            'thumbnails',
        ];
        if (in_array($value, $excluded)) return false;
        if (strpos($value, '.') !== false) return false;
        return true;
    }

    public static function recursive($dir)
    {
        $result = [];
        $array = scandir($dir);
        foreach ($array as $key => $value) {
            if (!in_array($value, ['.', '..'])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = self::recursive($dir . DIRECTORY_SEPARATOR . $value);
                } else {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

    public static function portals($dir)
    {
        $array = self::recursive($dir);
        $result = [];
        foreach ($array as $key => $value) {
            if (is_numeric($key) && !in_array($value, ['.gitkeep', 'thumbnails'])) {
                $result[] = $value;
            }
        }

        return $result;
    }
}
