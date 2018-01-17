<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 * @last modified by:   jRimbault
 * @last lodified time: 2018-01-15
 */

define('__ROOT__', __DIR__);
define('__IMGDIR__', __ROOT__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img');

function recursiveScandir($dir)
{
    $result = [];
    $array = scandir($dir);
    foreach ($array as $key => $value) {
        if (!in_array($value, [".", ".."])) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = recursiveScandir($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function getPortal($dir)
{
    $array = recursiveScandir($dir);
    $result = [];
    foreach ($array as $key => $value) {
        if (is_numeric($key) && !in_array($value, ['.gitkeep', 'thumbnails'])) {
            $result[] = $value;
        }
    }

    return $result;
}

function jsonResponse($array, $code = 200)
{
    header('Content-Type: text/json');
    http_response_code($code);
    die(json_encode($array));
}

function filterArrayForThumbnails($value)
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

function getGalleryFolders($dir)
{
    $array = scandir($dir);
    return array_filter($array, "filterArrayForThumbnails");
}

function makeThumbnails($script, $dir)
{
    $folders = getGalleryFolders($dir);
    foreach ($folders as $folder) {
        $target = $dir . DIRECTORY_SEPARATOR . $folder;
        $command = '/bin/bash ' .  $script . ' ' . $target;
        shell_exec($command);
    }
    die('Should be done');
}
