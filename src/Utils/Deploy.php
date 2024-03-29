<?php

namespace Gallery\Utils;

use Conserto\Path;
use Gallery\Utils\Filesystem\File;

/**
 * This class is used by composer after the initial `composer install`.
 * It will deploy jQuery, Bootstrap, Popper.js, and ekko-lightbox
 * to the web front-end.
 * If there's no config file already, it will write a default one.
 */
class Deploy
{
    public static function Install()
    {
        Path::setRoot(dirname(dirname(__DIR__)));
        self::Conf();
        self::jQuery();
        self::Bootstrap();
        self::popperjs();
        self::ekkoLightbox();
        self::colorpicker();
    }

    /** Initialize a default configuration file */
    public static function Conf()
    {
        $file = new Path('/config/app.json');
        $ini = self::makeJsonConf();
        if (!$file->fileExists() && file_put_contents($file->get(), $ini)) {
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
            '/public/assets/lib/jquery',
            'jQuery'
        );
    }

    /** Push Bootstrap to the web front end */
    public static function Bootstrap()
    {
        self::deployLib(
            '/vendor/twbs/bootstrap/dist',
            '/public/assets/lib/bootstrap',
            'Boostrap'
        );
    }

    /** Push Popper.js to the web front end */
    public static function popperjs()
    {
        self::deployLib(
            '/vendor/FezVrasta/popper.js/dist',
            '/public/assets/lib/popper',
            'popper.js'
        );
    }

    /** Push ekko-lightbox to the web front end */
    public static function ekkoLightbox()
    {
        self::deployLib(
            '/vendor/ashleydw/lightbox/dist',
            '/public/assets/lib/lightbox',
            'ekko-lightbox'
        );
    }

    /** Push bootstrap-colorpicker to the web front end */
    public static function colorpicker()
    {
        self::deployLib(
            '/vendor/itsjavi/bootstrap-colorpicker/dist',
            '/public/assets/lib/colorpicker',
            'bootstrap-colorpicker'
        );
    }

    /**
     * Function to copy a directory lib to the web front end
     */
    private static function deployLib(string $src, string $dst, string $name)
    {
        $src = new Path($src);
        $dst = new Path($dst);
        if (File::rcopy($src->get(), $dst->get())) {
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
                'background' => 'ffffff',
                'lightbox' => '#ddd'
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
                'theater' => true,
                'dev' => false,
                'singlepage' => false
            ]
        ];
        return json_encode($conf, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
