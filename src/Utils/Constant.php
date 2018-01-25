<?php

namespace Gallery\Utils;


class Constant
{
    const ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
    const SRC = Constant::ROOT . 'src' . DIRECTORY_SEPARATOR;
    const VAR = Constant::ROOT . 'var' . DIRECTORY_SEPARATOR;
    const WEB = Constant::ROOT . 'public' . DIRECTORY_SEPARATOR;
    const LOG = Constant::VAR . 'log' . DIRECTORY_SEPARATOR;
    const CONFIG = Constant::ROOT . 'config' . DIRECTORY_SEPARATOR;
    const GALLERY = Constant::WEB . 'gallery' . DIRECTORY_SEPARATOR;
}
