<?php

use Gallery\Path;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;

function buildGalleryCards()
{
    $html = "";
    $scanner = new Scan(Path::Gallery());
    foreach ($scanner->getGalleries() as $gallery) {
        $html .=
            "<a href='$gallery'>
                <div class='card text-white bg-dark'>
                    <img class='card-img-top rounded' src='gallery/$gallery.jpg'>
                    <div class='card-img-overlay'>
                        <h4 class='card-title'>".ucfirst($gallery)."</h4>
                    </div>
                </div>
            </a>";
    }
    return $html;
}

$conf = Config::Instance();

?>
<!DOCTYPE html>
<html lang="fr">
<?php
require_once 'inc/head.php';
?>
<body class="bg-dark">
<?php
require_once 'inc/header.php';
?>
<main role="main">
    <div class="album text-muted">
        <div class="container">
            <div class="card-columns" id="gallery">
<?php
if (!$conf->getSinglePage()) {
    echo buildGalleryCards();
}
?>
            </div>
        </div>
    </div>
</main>
<?php
require_once 'inc/footer.php';
require_once 'inc/scripts.php';
if ($conf->getDev()) {
    require_once 'inc/dev-ribbon.html';
}
?>
</body>
</html>
