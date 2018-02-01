<?php
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

$title = '';
$gallery = '';
$homelink = '#';
if (!$conf->getSinglePage()) {
    $title = $conf->getTitle();
    $homelink = '/';
    if ($this->getURI()) {
        $gallery = '> ' . ucfirst($this->getURI());
    }
}


?>
<header>
    <div class="bg-dark collapse" id="navbarHeader" style="">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 py-4">
                    <h4 class="text-white">À propos</h4>
                    <p class="text-muted">
                        <?php echo $conf->getAbout(); ?>
                    </p>
                </div>
                <div class="col-sm-4 py-4">
                    <h4 class="text-white">Contact</h4>
                    <?php echo makeLinks($conf); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar fixed-top navbar-dark bg-dark">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand">
                <a href="<?php echo $homelink; ?>" class="navbar-brand" id="title">
                <?php
                echo $title;
                ?>
                </a>
                <span id="breadcrumbs">
                <?php
                echo $gallery;
                ?>
                </span>
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
