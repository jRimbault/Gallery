<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 */

define('__ROOT__', __DIR__ . DIRECTORY_SEPARATOR);
ini_set('error_log', __ROOT__ . 'log/php_error.log');
define('__CONF__', parse_ini_file(__ROOT__ . 'conf.ini', true));
define('__PUBDIR__', __ROOT__ . 'web' . DIRECTORY_SEPARATOR);
define('__IMGDIR__', __PUBDIR__ . 'gallery' . DIRECTORY_SEPARATOR);
