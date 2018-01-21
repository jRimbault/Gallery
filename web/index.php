<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'constants.init.php';

function makeLinks($conf)
{
    $html = '<ul class="list-unstyled">';
    for ($i = 0; $i < count($conf->getLink()); $i += 1) {
        $html .= '<li><a href="' . $conf->getLink()[$i]['url'] . '" class="text-white">';
        $html .= $conf->getLink()[$i]['text'] . '</a></li>';
    }
    $html .= '<li><a href="mailto:' . $conf->getEmail() . '" class="text-white">';
    $html .= $conf->getEmail() . '</a></li>';

    return $html . '</ul>';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $conf->getTitle(); ?></title>
    <link rel="stylesheet"
          href="assets/lib/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="assets/lib/css/ekko-lightbox-5.3.0.min.css">
    <link rel="stylesheet"
          href="assets/css/styles.css">
    <style type="text/css">
    <?php if (isHexColor($conf->getBackground())) { ?>
        .bg-dark {
            background-color: <?php echo '#' . $conf->getBackground(); ?> !important;
        }
    <?php } ?>
    <?php if (isHexColor($conf->getLightbox())) { ?>
        .ekko-lightbox .modal-content {
            background-color: <?php echo '#' . $conf->getLightbox(); ?> !important;
        }
    <?php } ?>
    </style>
</head>
<body class="bg-dark">

<header>
    <div class="bg-dark collapse" id="navbarHeader" style="">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 py-4">
                    <h4 class="text-white">À propos</h4>
                    <p class="text-muted">
                        <?php echo $conf->getAbout() ?>
                    </p>
                </div>
                <div class="col-sm-4 py-4">
                    <h4 class="text-white">Contact</h4>
                    <?php echo makeLinks($conf) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar fixed-top navbar-dark bg-dark">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand">
                <a href="#" class="navbar-brand" id="title"></a>
                <span id="breadcrumbs"></span>
            </span>
            <button class="navbar-toggler collapsed"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarHeader"
                    aria-controls="navbarHeader"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>

<main role="main">


    <!--<section class="jumbotron text-center" id="lead">
        <div class="container">
            <h1 class="jumbotron-heading">Chez Rimbault</h1>
        </div>
    </section>-->


    <div class="album text-muted">
        <div class="container">
            <div class="card-columns" id="gallery">

            </div>
        </div>
    </div>

</main>

<footer class="text-white bg-dark">
    <div class="container">
        <p>
            ©
            <a href="https://getbootstrap.com" class="text-white">Bootstrap,</a>
            adapté par
            <a href="https://jrimbault.github.io/" class="text-white">Jacques
                Rimbault</a>
        </p>
    </div>
</footer>

<script src="assets/lib/js/jquery-3.2.1.min.js"></script>
<script src="assets/lib/js/popper-1.12.9.min.js"></script>
<script src="assets/lib/js/bootstrap.min.js"></script>
<script src="assets/lib/js/ekko-lightbox-5.3.0.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

