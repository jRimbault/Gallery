<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 */

define('__ROOT__', __DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR);
define('__SRCDIR__', __ROOT__ . 'src' . DIRECTORY_SEPARATOR);
define('__VARDIR__', __ROOT__ . 'var' . DIRECTORY_SEPARATOR);
define('__WEBDIR__', __ROOT__ . 'web' . DIRECTORY_SEPARATOR);
define('__IMGDIR__', __WEBDIR__ . 'gallery' . DIRECTORY_SEPARATOR);
ini_set('error_log', __ROOT__ . 'log/php_error.log');

require_once __SRCDIR__ . 'functions.php';

$conf = new Config(__VARDIR__ . 'conf.ini');
