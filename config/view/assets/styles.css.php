<?php

header('Content-Type: text/css');

use Gallery\Utils\Config;
use Gallery\Path;

$conf = Config::Instance();

function isHexColor($input)
{
    if (!ctype_xdigit($input)) return false;
    if (!in_array(strlen($input), [3, 6])) return false;
    return true;
}

require_once Path::View() . '/assets/static/styles.css';

if (isHexColor($conf->getBackground())) {
?>
.bg-dark {
    background-color: #<?php echo $conf->getBackground(); ?> !important;
}
<?php
$hsl = RGBtoHSL(HTMLtoRGB($conf->getBackground()));
if ($hsl->lightness > 200) {
?>
ul li a.text-white, .navbar .navbar-brand {
    color: #000000 !important;
}
.navbar-dark .navbar-toggler {
    background-color: #c4c4c4 !important;
}
<?php
}

}
if (isHexColor($conf->getLightbox())) {
?>
.ekko-lightbox .modal-content {
    background-color: #<?php echo $conf->getLightbox(); ?> !important;
}
<?php
}

function HTMLtoRGB($htmlCode)
{
    $htmlCode = ltrim($htmlCode, '#');
    if (strlen($htmlCode) === 3) {
        $htmlCode = $htmlCode[0] . $htmlCode[0]
                  . $htmlCode[1] . $htmlCode[1]
                  . $htmlCode[2] . $htmlCode[2];
    }
    $r = hexdec($htmlCode[0] . $htmlCode[1]);
    $g = hexdec($htmlCode[2] . $htmlCode[3]);
    $b = hexdec($htmlCode[4] . $htmlCode[5]);

    return $b + ($g << 0x8) + ($r << 0x10);
}

function RGBtoHSL($RGB)
{
    $r = 0xFF & ($RGB >> 0x10);
    $g = 0xFF & ($RGB >> 0x8);
    $b = 0xFF & $RGB;

    $r = ( (float) $r ) / 255.0;
    $g = ( (float) $g ) / 255.0;
    $b = ( (float) $b ) / 255.0;

    $maxColor = max([$r, $g, $b]);
    $minColor = min([$r, $g, $b]);

    $lightness = ($maxColor + $minColor) / 2.0;

    if ($maxColor == $minColor) {
        $saturation = 0;
        $hue = 0;
    } else {
        if ($lightness < .5) {
            $saturation = ($maxColor - $minColor) / ($maxColor + $minColor);
        } else {
            $saturation = ($maxColor - $minColor) / (2.0 - $maxColor + $minColor);
        }
        switch ($maxColor) {
            case $r:
                $hue = ($g - $b) / ($maxColor - $minColor);
                break;
            case $g;
                $hue = 2.0 + ($b - $r) / ($maxColor - $minColor);
                break;
            case $b;
                $hue = 4.0 + ($r - $g) / ($maxColor - $minColor);
                break;
        }
        $hue /= 6.0;
    }

    $hue = (int) round(255.0 * $hue);
    $saturation = (int) round(255.0 * $saturation);
    $lightness = (int) round(255.0 * $lightness);

    return (object) [
        'hue' => $hue,
        'saturation' => $saturation,
        'lightness' => $lightness
    ];
}
