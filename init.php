<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 * @last modified by:   jRimbault
 * @last lodified time: 2018-01-15
 */

define('__ROOT__', __DIR__);

function scanDirRec($dir)
{
    $result = [];
    $array = scandir($dir);
    foreach ($array as $key => $value) {
        if (!in_array($value, [".", ".."])) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = scanDirRec($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function getThumbnails($dir)
{
    $array = scanDirRec($dir);
    $result = [];
    foreach ($array as $key => $value) {
        if (isset($value['thumbnails'])) {
            $result[$key] = $value['thumbnails'];
        }
    }

    return $result;
}

function getPortal($dir)
{
    $array = scanDirRec($dir);
    $result = [];
    foreach ($array as $key => $value) {
        if (is_numeric($key) && !in_array($value, ['.gitkeep'])) {
            $result[] = $value;
        }
    }

    return $result;
}

function jsonResponse($array, $code = 200)
{
    header('Content-Type: text/json');
    http_response_code(200);
    die(json_encode($array));
}
