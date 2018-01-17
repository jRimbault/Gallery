<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'init.php';

if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'portal':
                jsonResponse(getPortal(__IMGDIR__));
                break 2;
            case 'make':
                makeThumbnails(
                    __ROOT__ . DIRECTORY_SEPARATOR . 'makethumbnails.sh',
                    __IMGDIR__
                );
                break 2;
            default:
                jsonResponse(recursiveScandir(__IMGDIR__)[$key]);
                break 2;
        }
    }
}

jsonResponse(recursiveScandir(__IMGDIR__));
