<?php
$publication = unserialize($_SESSION['publication']);
$error = PublicationController::insertOrUpdatePublication($publication);

$publicationUrl = PublicationController::getPublicationUrl($publication, false);
$absolutePublicationUrl = PublicationController::getPublicationUrl($publication);
$wikiPath = PublicationController::getPublicationWikiPath($publication, false);
?>

<div id="main_page" class="page">
    <?php
    if($error == '') {
        $url = PublicationController::getPublicationWikiPath($publication);
        echo '<p>La publication a bien été créée</p>';
        echo '<p>Lien vers le wiki : <a href="'.$wikiPath.'">'.$wikiPath.'</a></p>';
        echo '<p>Page créée : <a href="'.$absolutePublicationUrl.'">'.$publicationUrl.'</a></p>';
    } else {
        echo 'error: '.$error;
    }
    ?>
</div>