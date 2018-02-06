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
    'link' =>  $request->post->get('link') ?? [],
    'switch' => [],
];

$conf['site']['title'] = $request->post->get('title') ?? '';
$conf['site']['about'] = $request->post->get('about') ?? '';
$conf['site']['email'] = $request->post->get('email') ?? '';

$conf['color']['background'] = removeHash($request->post->get('background') ?? '');
$conf['color']['lightbox'] = removeHash($request->post->get('lightbox') ?? '');

$conf['switch']['dev'] = ($request->post->get('dev') == 'true');
$conf['switch']['singlepage'] = ($request->post->get('singlepage') == 'true');
$conf['switch']['theater'] = true;

$file = Path::Root() . '/config/app.json';

if ($written = !file_exists($file)) {
    Json::writeToFile($conf, $file);
}

Json::Response([
    'status' => $written,
    'conf' => $conf
]);
