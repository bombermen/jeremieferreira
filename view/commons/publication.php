<!-- warning: $publication and $content must be set -->

<div id="main_page" class="page">
    <div id="abstract">
        
        <h1><?php echo $publication->getTitle(); ?></h1>
        
        <div id="abstract">
            <?php echo $publication->getShortDescription(); ?>
        </div>
        
        <?php echo Utils::generateTableOfContents($content); ?>
        
    </div>
    <?php require PublicationController::getPublicationMainPageUrl($publication); ?>
</div>