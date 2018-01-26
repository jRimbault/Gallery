<?php

namespace Gallery\Utils\Filesystem;

use Gallery\Path;


class File
{
    public static function deleteFiles($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK);
            foreach ($files as $file) {
                self::deleteFiles($file);
            }
            rmdir($target);
        } else if (is_file($target)) {
            unlink($target);
        }
    }

    public static function Deploy()
    {
        /** jQuery */
        $src = Path::Root() . '/vendor/components/jquery';
        $dst = Path::AssetsLib() . '/jquery';
        if (self::rcopy($src, $dst)) {
            echo "  jQuery deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install jQuery properly" . PHP_EOL;
        }
        /** Bootstrap */
        $src = Path::Root() . '/vendor/twbs/bootstrap/dist';
        $dst = Path::AssetsLib() . '/bootstrap';
        if (self::rcopy($src, $dst)) {
            echo "  Bootstrap deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install Bootstrap properly" . PHP_EOL;
        }
        if (self::makeIniConf()) {
            echo "  Configuration file: `config/app.ini`" . PHP_EOL;
        } else {
            echo "  Configuration file already exists (`config/app.ini`)" . PHP_EOL;
        }
    }

    /** Mostly stolen from a comment on the php manual */
    private static function rcopy($src, $dst)
    {
        if (is_dir($src)) {
            @mkdir($dst, 0755, true);
            foreach (scandir($src) as $file) {
                if ($file != '.' && $file != '..') {
                    self::rcopy("$src/$file", "$dst/$file");
                }
            }
            return true;
        } else if (is_file($src)) {
            @copy($src, $dst);
            return true;
        }
        return false;
    }

    private static function makeIniConf()
    {
        $confFile = Path::Root() . '/config/app.ini';
        if (file_exists($confFile)) return false;
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
        return self::put_ini_file($confFile, $conf);
    }

    /** This is tailor made and not really good */
    private static function put_ini_file($file, $array, $i = false)
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
                $str .= self::put_ini_file("", $v, true);
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
        if ($file) {
            return file_put_contents($file, $str);
        } else {
            return $str;
        }
    }
}
