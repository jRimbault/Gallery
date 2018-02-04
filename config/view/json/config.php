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

$conf['switch']['dev'] = ($_POST['dev'] == 'true');
$conf['switch']['singlepage'] = ($_POST['singlepage'] == 'true');
$conf['switch']['theater'] = true;

$file = Path::Root() . '/config/app.json';

if ($written = !file_exists($file)) {
    Json::writeToFile($conf, $file);
}

Json::Response([
    'status' => $written,
    'conf' => $conf
]);
