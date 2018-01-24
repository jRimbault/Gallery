<?php

namespace Utils;

use Utils\Constant;
use Utils\Filesystem\Scan;
use Utils\Filesystem\Thumbnail;
use Utils\Filesystem\File;

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
        if ($this->getMakeThumb()) {
            $this->makeThumbnails();
        }
        if ($this->getDeleteThumb()) {
            $this->deleteThumbnails();
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
        $counter = 0;
        foreach ($scanner->getGalleries() as $gallery) {
            $this->galleryState($gallery, $scanner);
            foreach ($scanner->getGallery($gallery) as $image) {
                $thumb = new Thumbnail($gallery, $image);
                try {
                    if ($thumb->make()) {
                        $counter += 1;
                    }
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->message("  $counter thumbnails generated");
            $counter = 0;
        }
    }

    private function deleteThumbnails()
    {
        $scanner = new Scan(Constant::GALLERY);
        foreach ($scanner->getGalleries() as $gallery) {
            foreach ($scanner->getGallery($gallery) as $image) {
                $path = Constant::GALLERY . $gallery . DIRECTORY_SEPARATOR . 'thumbnails';
                File::deleteFiles($path);
            }
        }
    }

    private function galleryState($gallery, $scanner)
    {
        $msg = '- ' . ucfirst($gallery);
        $msg .= ' (' . count($scanner->getGallery($gallery)) . ')';
        $this->message($msg);
    }
}
