<?php

namespace Gallery\Utils;

use Gallery\Path;
use Gallery\Utils\Filesystem\File;

/**
 * This class is used by composer after the initial `composer install`.
 * It will deploy jQuery, Bootstrap, Popper.js, and ekko-lightbox
 * to the web front-end.
 * If there's no config file alreay, it will write a default one.
 */
class Deploy
{
    /** Initialize a default configuration file */
    public static function Conf()
    {
        $file = '/config/app.json';
        $dst = Path::Root() . $file;
        $ini = self::makeJsonConf();
        if (!file_exists($dst) && file_put_contents($dst, $ini)) {
            echo "  Configuration file: `$file`" . PHP_EOL;
        } else {
            echo "  Configuration file already exists (`$file`)" . PHP_EOL;
        }
    }

    /** Push jQuery to the web front end */
    public static function jQuery()
    {
        self::deployLib(
            '/vendor/components/jquery',
            '/jquery',
            'jQuery'
        );
    }

    /** Push Bootstrap to the web front end */
    public static function Bootstrap()
    {
        self::deployLib(
            '/vendor/twbs/bootstrap/dist',
            '/bootstrap',
            'Boostrap'
        );
    }

    /** Push Popper.js to the web front end */
    public static function popperjs()
    {
        self::deployLib(
            '/vendor/FezVrasta/popper.js/dist',
            '/popper',
            'popper.js'
        );
    }

    /** Push ekko-lightbox to the web front end */
    public static function ekkoLightbox()
    {
        self::deployLib(
            '/vendor/ashleydw/lightbox/dist',
            '/lightbox',
            'ekko-lightbox'
        );
    }

    /** Push bootstrap-colorpicker to the web front end */
    public static function colorpicker()
    {
        self::deployLib(
            '/vendor/itsjavi/bootstrap-colorpicker/dist',
            '/colorpicker',
            'bootstrap-colorpicker'
        );
    }

    /**
     * Function to copy a directory lib to the web front end
     */
    private static function deployLib(string $src, string $dst, string $name)
    {
        $src = Path::Root() . $src;
        $dst = Path::AssetsLib() . $dst;
        if (File::rcopy($src, $dst)) {
            echo "  $name deployed" . PHP_EOL;
        } else {
            echo "  Couldn't install $name properly" . PHP_EOL;
        }
    }

    /** Default configuration */
    private static function makeJsonConf()
    {
        $conf = [
            'site' => [
                'title' => 'Example',
                'about' => 'Some text about the website',
                'email' => 'email@example.org'
            ],
            'color' => [
                'background' => '212529',
                'lightbox' => '212529'
            ],
            'link' => [
                [
                    'url' => 'https://www.example.org',
                    'text' => 'A website example',
                ],
                [
                    'url' => 'https://www.google.com',
                    'text' => 'Google',
                ],
                [
                    'url' => 'https://you.can-set.an-url.without/a-text',
                ]
            ],
            'switch' => [
                'theater' => false,
                'dev' => true,
                'singlepage' => false
            ]
        ];
        return json_encode($conf, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
