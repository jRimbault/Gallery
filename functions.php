<?php

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

function makeLinks()
{
    $html = '<ul class="list-unstyled">';
    for ($i = 0; $i < count(__CONF__['LINK']['url']); $i += 1) {
        $html .= '<li><a href="' . __CONF__['LINK']['url'][$i] . '" class="text-white">';
        $html .= __CONF__['LINK']['text'][$i] . '</a></li>';
    }
    $html .= '<li><a href="mailto:' . __CONF__['SITE']['email'] . '" class="text-white">';
    $html .= __CONF__['SITE']['email'] . '</a></li>';

    return $html . '</ul>';
}

function isHexColor($input)
{
    if (!ctype_xdigit($input)) return false;
    if (!in_array(strlen($input), [3, 6])) return false;
    return true;
}