<?php

use Gallery\Path;
use Gallery\Utils\Config;

if (file_exists(Path::Root() . '/config/app.json')) {
    require_once Path::View() . '/error/404.php';
    die();
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
    <div class="container jumbotron">
        <h1 class="display-4">Configuration</h1>
        <hr class="my-4">
        <div class="row">
            <form class="col" id="configform" action="/configuration" method="POST">

                <div class="row">
                    <div class="col-2"></div>
                    <h2 class="col">Website</h2>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label text-right">
                        Website name
                    </label>
                    <div class="col">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Nulla Ligula">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label text-right">
                        Contact email
                    </label>
                    <div class="col">
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="about" class="col-sm-2 col-form-label text-right">
                        About
                    </label>
                    <div class="col">
                        <textarea type="textarea" class="form-control" name="about" id="about" rows="3"></textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-2"></div>
                    <h2 class="col">Colors</h2>
                </div>

                <div class="form-group row">
                    <label for="background" class="col-sm-2 col-form-label text-right">
                        Background
                    </label>
                    <div class="col-sm-4 input-group colorpicker-component" id="background10">
                        <input type="text" class="form-control input-lg" name="background" id="background" readonly>
                        <div class="input-group-append input-group-addon">
                            <button class="btn btn-outline-secondary" type="button">
                                Pick
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lightbox" class="col-sm-2 col-form-label text-right">
                        Lightbox
                    </label>
                    <div class="col-sm-4 input-group colorpicker-component" id="lightbox10">
                        <input type="text" class="form-control" name="lightbox" id="lightbox" readonly>
                        <div class="input-group-append input-group-addon">
                            <button class="btn btn-outline-secondary" type="button">
                                Pick
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-2"></div>
                    <h2 class="col">Links</h2>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-2"></div>
                    <h2 class="col">Switches</h2>
                </div>

                <div class="row">
                    <label for="singlepage" class="col-sm-2 col-form-label text-right">
                        Single page
                    </label>
                    <div class="col">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="singlepage-on" name="singlepage" class="custom-control-input" value="true">
                            <label class="custom-control-label" for="singlepage-on">On</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="singlepage-off" name="singlepage" class="custom-control-input" value="false" checked="true">
                            <label class="custom-control-label" for="singlepage-off">Off</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"></div>
                    <hr class="col">
                </div>

                <div class="row">
                    <label for="dev" class="col-sm-2 col-form-label text-right">
                        Dev mode
                    </label>
                    <div class="col">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="devmode-on" name="dev" class="custom-control-input" value="true">
                            <label class="custom-control-label" for="devmode-on">On</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="devmode-off" name="dev" class="custom-control-input" value="false" checked="true">
                            <label class="custom-control-label" for="devmode-off">Off</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col">
                        <input class="btn btn-outline-dark" type="submit" value="Submit">
                    </div>
                </div>
            </form>
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
<script>
$(function () {
    $('#lightbox10').colorpicker({
        useHashPrefix: false,
        fallBackColor: true
    });
    $('#background10').colorpicker({
        useHashPrefix: false,
        fallBackColor: true
    }).on('changeColor', e => {
        let color = e.color.toString('hex');
        $('.bg-dark').attr('style', 'background-color:' + color + ' !important');;
    });
});
$('#configform').submit(event => {
    event.preventDefault();
    $.post('/configuration', $('#configform').serializeArray(), json => {
        console.log(json);
    }).fail(xhr => {
        console.log(xhr);
    });
});
</script>
</body>
</html>
