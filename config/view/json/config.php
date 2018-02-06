<?php

use Gallery\Path;
use Gallery\Utils\Json;
use Gallery\Utils\Http\Request;

function removeHash(string $string)
{
    return ltrim($string, '#');
}

$request = new Request();

$conf = [
    'site' => [],
    'color' => [],
    'link' =>  $request->getPost('link') ?? [],
    'switch' => [],
];

$conf['site']['title'] = $request->getPost('title') ?? '';
$conf['site']['about'] = $request->getPost('about') ?? '';
$conf['site']['email'] = $request->getPost('email') ?? '';

$conf['color']['background'] = removeHash($request->getPost('background') ?? '');
$conf['color']['lightbox'] = removeHash($request->getPost('lightbox') ?? '');

$conf['switch']['dev'] = ($request->getPost('dev') == 'true');
$conf['switch']['singlepage'] = ($request->getPost('singlepage') == 'true');
$conf['switch']['theater'] = true;

$file = Path::Root() . '/config/app.json';

if ($written = !file_exists($file)) {
    Json::writeToFile($conf, $file);
}

Json::Response([
    'status' => $written,
    'conf' => $conf
]);
