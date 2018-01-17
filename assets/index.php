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
                if (in_array($key, getGalleryFolders(__IMGDIR__))) {
                    jsonResponse(recursiveScandir(__IMGDIR__)[$key]);
                }
                jsonResponse([
                    'status' => 404,
                    'message' => "No '$key' gallery",
                ], 404);
                break 2;
        }
    }
}

jsonResponse(recursiveScandir(__IMGDIR__));
