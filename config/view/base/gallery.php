<?php

use Gallery\Path;
use Gallery\Utils\Config;
use Gallery\Utils\Filesystem\Scan;


$conf = Config::Instance();

function buildImgCard($gallery)
{
    $html = "";
    $scanner = new Scan(Path::Gallery());
    foreach($scanner->getGallery($gallery) as $image) {
        $html .= "<div class='card text-white bg-dark mb-3'>";
        $html .= "<a href='gallery/$gallery/$image' data-toggle='lightbox' data-gallery='album'>";
        $html .= "<img class='card-img-top rounded' src='gallery/$gallery/thumbnails/$image'>";
        $html .= '</a>';
        $html .= '</div>';
    }
    return $html;
}

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
?>
<main role="main">
    <div class="album text-muted">
        <div class="container">
            <div class="card-columns" id="gallery">
<?php
if (!$conf->getSinglePage()) {
    echo buildImgCard($this->getURI());
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
