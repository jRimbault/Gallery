<?php

namespace Utils;

use Utils\Filesystem\Scan;
use Utils\Filesystem\Thumbnail;


class Console
{
    private $option;

    private function error($input)
    {
        fwrite(STDERR, $input . PHP_EOL);
        error_log($input);
    }

    private function message($input)
    {
        fwrite(STDOUT, $input . PHP_EOL);
    }

    private function setOptions($argv)
    {
        $this->option = [];
        foreach ($argv as $arg) {
            $e = explode('=', $arg);
            $this->option[strtolower($e[0])] = true;
            if (count($e) == 2) {
                $this->option[strtolower($e[0])] = $e[1];
            }
        }
    }

    private function isCli()
    {
        return php_sapi_name() === 'cli';
    }

    public function __construct($argv)
    {
        if (!$this->isCli()) {
            $this->error('This script must invoked from the command line');
            exit(1);
        }
        $this->setOptions($argv);
        if ($this->getMakethumb()) {
            $this->makeThumbnails();
        }
    }

    public function __call($method, $params)
    {
        if (strncasecmp($method, 'get', 3) !== 0) return false;
        $var = strtolower(substr($method, 3));
        if (!isset($this->option[$var])) return false;

        return $this->option[$var];
    }

    private function makeThumbnails()
    {
        $scanner = new Scan(Constant::GALLERY);
        $this->message('Scanning the galleries...');
        foreach ($scanner->getGalleries() as $gallery) {
            $this->message('- ' . ucfirst($gallery));
            $thumbDir = Constant::GALLERY . $gallery . DIRECTORY_SEPARATOR . 'thumbnails';
            if (!file_exists($thumbDir)) {
                mkdir($thumbDir, 0755);
            }
            foreach ($scanner->getGallery($gallery) as $image) {
                try {
                    $thumb = new Thumbnail($gallery, $image);
                    if ($thumb->make()) {
                        $this->message("Thumbnail of $image made");
                    }
                } catch (Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->message('  ' . count($scanner->getGallery($gallery)) . ' pictures');
        }
    }
}
