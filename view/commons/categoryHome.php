<div id='main_page' class="page">
    <?php
    $publications = DAOFactory::getPublicationDAO()->selectAll();
    
    echo '<h1>' . Utils::removeUnderscores($category) . '</h1>';
    
    foreach($publications as $publication) {
        
        $image = PublicationController::getThumbImageUrl($publication);
        $title = $publication->getTitle();
        $titleId = Utils::addUnderscores($title);
        
        echo '    <a href="' . $category . '/' . Utils::addUnderscores($title, false) . '" class="publicationThumb">'
        . '        <img src="' . $image . '" alt="' . $title . '" /><br/>'
        . '        <div class="publicationThumbLabel">'. $title .'</div>'
        . '    </a>';
        
    }
    ?>
</div>

<script src="jeremieferreira/view/commons/publicationBrowser.js"></script>