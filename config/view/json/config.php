<?php

use Gallery\Path;
use Gallery\Utils\Json;

function removeHash(string $string)
{
    return ltrim($string, '#');
}

$conf = [
    'site' => [],
    'color' => [],
    'link' => [],
    'switch' => [],
];

$conf['site']['title'] = $_POST['title'] ?? '';
$conf['site']['about'] = $_POST['about'] ?? '';
$conf['site']['email'] = $_POST['email'] ?? '';

$conf['color']['background'] = removeHash($_POST['background'] ?? '');
$conf['color']['lightbox'] = removeHash($_POST['lightbox'] ?? '');

$conf['switch']['dev'] = (boolean) ($_POST['dev'] ?? false);
$conf['switch']['singlepage'] = (boolean) ($_POST['singlepage'] ?? false);
$conf['switch']['theater'] = (boolean) ($_POST['theater'] ?? true);

$file = Path::Root() . '/config/app.json';

if (!file_exists($file)) {
    Json::writeToFile($conf, $file);
}

Json::Response($conf);
