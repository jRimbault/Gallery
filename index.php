<?php
/**
 * @author: jRimbault
 * @date:   2018-01-15
 */

function makeLinks($c = [])
{
    $html = '<ul class="list-unstyled">';
    for ($i = 0; $i < count($c['LINK']['url']); $i += 1) {
        $html .= '<li><a href="' . $c['LINK']['url'][$i] . '" class="text-white">' . $c['LINK']['text'][$i] . '</a></li>';
    }
    $html .= '<li><a href="mailto:' . $c['SITE']['email'] . '" class="text-white">' . $c['SITE']['email'] . '</a></li>';
    return $html . '</ul>';
}

$c = parse_ini_file('public.conf.ini', true);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $c['SITE']['title'] ?></title>
    <link rel="stylesheet"
          href="assets/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="assets/css/ekko-lightbox-5.3.0.min.css">
    <link rel="stylesheet"
          href="assets/css/styles.css">
    <?php
    if (isset($c['SITE']['background']) &&
        ctype_xdigit($c['SITE']['background']) &&
        strlen($c['SITE']['background']) === 6) {
        ?>
        <style type="text/css">
            .bg-dark {
                background-color: <?php echo '#' . $c['SITE']['background']; ?> !important;
            }
        </style>
        <?php
    }
    ?>
</head>
<body class="bg-dark">

<header>
    <div class="bg-dark collapse" id="navbarHeader" style="">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 py-4">
                    <h4 class="text-white">À propos</h4>
                    <p class="text-muted">
                        <?php echo $c['SITE']['about'] ?>
                    </p>
                </div>
                <div class="col-sm-4 py-4">
                    <h4 class="text-white">Contact</h4>
                    <?php echo makeLinks($c) ?>
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

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper-1.12.9.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ekko-lightbox-5.3.0.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

