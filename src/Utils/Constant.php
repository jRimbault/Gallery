<?php

//namespace App\Utils;


class Constant
{
    const ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
    const LOG = Constant::ROOT . 'log' . DIRECTORY_SEPARATOR;
    const SRC = Constant::ROOT . 'src' . DIRECTORY_SEPARATOR;
    const VAR = Constant::ROOT . 'var' . DIRECTORY_SEPARATOR;
    const WEB = Constant::ROOT . 'web' . DIRECTORY_SEPARATOR;
    const GALLERY = Constant::WEB . 'gallery' . DIRECTORY_SEPARATOR;
}
