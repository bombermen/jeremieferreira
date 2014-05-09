<?php
$categories = array("Accueil", "Projets", "Tutoriels", "Fiches Techniques", "Articles", "CV", "Contact");

foreach($categories as $category) {
    echo '<li><a class="' . $class . '" href="' . SITE_BASE . Utils::addUnderscores($category, false) . '">' . $category . '</a></li>';
}

?>

<!--
<ul>
    <li><a id="main_menu_button" class="menu_button">JF</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Accueil">Accueil</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Projets">Projets</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Tutoriels">Tutoriels</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Fiches Techniques">Fiches Techniques</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Articles">Articles</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/CV">CV</a></li>
    <li><a class="menu_button large_menu_button" href="http://localhost/jeremieferreira/Contact">Contact</a></li>
</ul>
-->