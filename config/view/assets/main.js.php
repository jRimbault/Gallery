<?php

use Gallery\Utils\Config;
use Gallery\Path;

header('Content-Type: application/javascript');

$gallery = basename(Path::Gallery()) . '/';

$conf = Config::Instance();

?>
'use strict';

const theater = <?php echo $conf->getTheater() ? 'true' : 'false'; ?>;
const galleryDirectory = '<?php echo $gallery; ?>';
const thumbnailsDirectory = (name) => galleryDirectory + name + '/thumbnails/';

<?php
require_once Path::View() . '/assets/static/main.js';
