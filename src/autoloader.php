<?php

function class_autoloader($class)
{
    $directories = [
        __DIR__ . DIRECTORY_SEPARATOR . 'Utils' . DIRECTORY_SEPARATOR,
    ];

    foreach ($directories as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
}

spl_autoload_register('class_autoloader');
