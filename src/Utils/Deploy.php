<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Filesystem\File;


class Deploy
{
    public static function Conf()
    {
        $file = '/config/app.ini';
        $dst = Path::Root() . $file;
        $ini = self::makeIniConf();
        if (!file_exists($dst) && file_put_contents($dst, $ini)) {
            echo "  Configuration file: `$file`" . PHP_EOL;
        } else {
            echo "  Configuration file already exists (`$file`)" . PHP_EOL;
        }
    }

    public static function jQuery()
    {
        self::deployLib(
            '/vendor/components/jquery',
            '/jquery',
            'jQuery'
        );
    }

    public static function Bootstrap()
    {
        self::deployLib(
            '/vendor/twbs/bootstrap/dist',
            '/bootstrap',
            'Boostrap'
        );
    }

    private static function deployLib($src, $dst, $name)
    {
        $src = Path::Root() . $src;
        $dst = Path::AssetsLib() . $dst;
        if (File::rcopy($src, $dst)) {
            echo "  $name deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install $name properly" . PHP_EOL;
        }
    }

    private static function makeIniConf()
    {
        $conf = [
            'SITE' => [
                'title' => 'Example',
                'about' => 'Some text about the website',
                'email' => 'email@example.org'
            ],
            'COLOR' => [
                'background' => '212529',
                'lightbox' => '212529'
            ],
            'LINK' => [
                'url' => [
                    'https://www.example.org',
                    'https://www.google.com',
                    'https://you.can-set.an-url.without/a-text'
                ],
                'text' => [
                    'A website example',
                    'Google'
                ]
            ],
            'SWITCH' => [
                'theater' => false
            ]
        ];
        return self::arrayToIniString($conf);
    }

    /** This is tailor made and not really good */
    private static function arrayToIniString($array, $i = false)
    {
        $str = "";
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                if ($i === false) {
                    $str .= "[$k]" . PHP_EOL;
                } else {
                    foreach ($v as $v2) {
                        $str .= $k . "[] = \"$v2\"" . PHP_EOL;
                    }
                }
                $str .= self::arrayToIniString($v, true);
            } else {
                if (!is_numeric($k) && !is_bool($v)) {
                    $str .= "$k = \"$v\"" . PHP_EOL;
                }
                if (is_bool($v)) {
                    $sub = $v ? 'true' : 'false';
                    $str .= "$k = " . $sub . PHP_EOL;
                }
            }
        }
        return $str;
    }
}
