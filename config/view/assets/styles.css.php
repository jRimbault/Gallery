<?php

header('Content-Type: text/css');

use Gallery\Path;
use Gallery\Utils\Color;
use Gallery\Utils\Config;

$conf = Config::Instance();

$bg = new Color('#ffffff');
$lb = new Color('#ffffff');

if ($conf->getBackground()) {
    try {
        $bg = new Color($conf->getBackground());
    } catch (\Exception $e) {
        error_log($e->getMessage());
    }
}
if ($conf->getLightbox()) {
    try {
        $lb = new Color($conf->getLightbox());
    } catch (\Exception $e) {
        error_log($e->getMessage());
    }
}

require_once Path::View() . '/assets/static/styles.css';

?>
.bg-dark {
    background-color: <?php echo $bg; ?> !important;
}
.ekko-lightbox .modal-content {
    background-color: <?php echo $lb; ?> !important;
}
<?php
if ($bg->getLightness() > 200) {
?>
ul li a.text-white, .navbar .navbar-brand {
    color: #000000 !important;
}
.navbar-dark .navbar-toggler {
    background-color: #c4c4c4 !important;
}
<?php
}
