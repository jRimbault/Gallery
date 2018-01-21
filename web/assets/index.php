<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'constants.init.php';

if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'portal':
                jsonResponse(getPortal(__IMGDIR__));
                break 2;
            default:
                if (in_array($key, getGalleryFolders(__IMGDIR__))) {
                    $directory = __IMGDIR__ . $key . DIRECTORY_SEPARATOR . 'thumbnails';
                    jsonResponse(recursiveScandir($directory));
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
