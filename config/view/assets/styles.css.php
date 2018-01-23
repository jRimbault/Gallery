<?php

header('Content-Type: text/css');

use Utils\Config;

global $conf;

function isHexColor($input)
{
    if (!ctype_xdigit($input)) return false;
    if (!in_array(strlen($input), [3, 6])) return false;
    return true;
}

?>
a, button {
    outline: 0 !important;
}

main {
    padding-top: 6rem;
    padding-bottom: 3em;
}

.navbar-brand {
    margin-right: 0;
}

footer {
    padding-top: 3rem;
    padding-bottom: 3rem;
}

<?php
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
