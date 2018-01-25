<?php

header('Content-Type: text/css');

use Gallery\Utils\Config;
use Gallery\Utils\Constant;

global $conf;

function isHexColor($input)
{
    if (!ctype_xdigit($input)) return false;
    if (!in_array(strlen($input), [3, 6])) return false;
    return true;
}

require_once Constant::CONFIG . 'view/assets/static/styles.css';

if (isHexColor($conf->getBackground())) {
?>
.bg-dark {
    background-color: #<?php echo $conf->getBackground(); ?> !important;
}
<?php
}
if (isHexColor($conf->getLightbox())) {
?>
.ekko-lightbox .modal-content {
    background-color: #<?php echo $conf->getLightbox(); ?> !important;
}
<?php
}
