<?php

require_once __DIR__ . '/../init.php';

if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'thumbnails':
                jsonResponse(getThumbnails(__DIR__ . '/img'));
                break 2;
            case 'portal':
                jsonResponse(getPortal(__DIR__ . '/img/'));
                break 2;
            default:
                jsonResponse(scanDirRec(__DIR__ . '/img')[$key]);
                break 2;
        }
    }
}

jsonResponse(scanDirRec(__DIR__ . '/img'));
