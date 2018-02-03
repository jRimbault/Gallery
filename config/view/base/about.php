<?php

use Gallery\Utils\Config;


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
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Hello, world!</h1>
            <p class="lead">
                Vestibulum lacus erat, dictum at justo ac, finibus convallis
                nisi. Morbi gravida efficitur orci a tempor
            </p>
            <hr class="my-4">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Nulla auctor aliquam ligula, ac pellentesque nisi. Nam dapibus, quam
                vitae commodo condimentum, justo metus scelerisque velit, at maximus
                purus tellus in nisi. Nullam nulla ligula, faucibus a est ut, suscipit
                semper mi. Vestibulum lacus erat, dictum at justo ac, finibus convallis
                nisi. Morbi gravida efficitur orci a tempor.
            </p>
        </div>
    </div>
</main>
<?php
require_once 'inc/footer.html';
require_once 'inc/scripts.html';
if ($conf->getDev()) {
    require_once 'inc/dev-ribbon.html';
}
?>
</body>
</html>
