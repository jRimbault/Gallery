<?php

use Gallery\Path;
use Gallery\Utils\Config;

$conf = Config::Instance();

?>
'use strict';

const theater = <?php echo $conf->getTheater() ? 'true' : 'false'; ?>;
const singlepage = <?php echo $conf->getSinglePage() ? 'true' : 'false'; ?>;
const galleryDirectory = 'gallery/';
const thumbnailsDirectory = (name) => galleryDirectory + name + '/thumbnails/';

<?php

require new Path('/config/views/assets/static/main.js');
