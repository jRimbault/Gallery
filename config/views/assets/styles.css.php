<?php

use Gallery\Path;
use Gallery\Utils\Color;


require new Path('/config/views/assets/static/styles.css');

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
