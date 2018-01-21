<?php

function class_autoloader($class)
{
    $directories = [
        __SRCDIR__ . 'Utils' . DIRECTORY_SEPARATOR,
    ];

    foreach ($directories as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
}

spl_autoload_register('class_autoloader');

function recursiveScandir($dir)
{
    $result = [];
    $array = scandir($dir);
    foreach ($array as $key => $value) {
        if (!in_array($value, ['.', '..'])) {
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
    header('Content-Type: application/json');
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
    return array_filter($array, 'filterArrayForThumbnails');
}

function generateThumbnails($script, $dir)
{
    $folders = getGalleryFolders($dir);
    foreach ($folders as $folder) {
        $target = $dir . DIRECTORY_SEPARATOR . $folder;
        $command = '/bin/bash ' . $script . ' ' . $target;
        shell_exec($command);
    }
    die('Should be done');
}

function isHexColor($input)
{
    if (!ctype_xdigit($input)) return false;
    if (!in_array(strlen($input), [3, 6])) return false;
    return true;
}
