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
require_once 'home/main.php';
require_once 'inc/footer.php';
require_once 'inc/scripts.php';
if ($conf->getDev()) {
    require_once 'inc/dev-ribbon.html';
}
?>
</body>
</html>
