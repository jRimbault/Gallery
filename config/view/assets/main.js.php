<?php

use Utils\Config;
use Utils\Constant;

header('Content-Type: application/javascript');

$array = explode(
    DIRECTORY_SEPARATOR,
    trim(Constant::GALLERY, DIRECTORY_SEPARATOR)
);
$gallery = $array[count($array) - 1] . '/';

global $conf;

?>
'use strict';

const theater = <?php echo $conf->getTheater() ? 'true' : 'false'; ?>;
const galleryDirectory = '<?php echo $gallery; ?>';
const thumbnailsDirectory = (name) => galleryDirectory + name + '/thumbnails/';

<?php
require_once Constant::CONFIG . 'view/assets/static/main.js';
