<?php

//website
define('SITE_BASE', 'http://localhost/jeremieferreira/');
define('URL_BEGIN', 2); //position of the first element after domain name in url
define('TOC_TITLE', 'Sommaire');
$GLOBALS['CATEGORIES'] = array('Projets', 'Tutoriels', 'Fiches_Techniques', 'Articles');

//server
define('SERVER_BASE', 'C:/wamp/www/jeremieferreira/');
define('RESOURCES', 'resources/');
define('PUBLICATIONS_FOLDER', 'Publications/');
define('MAIN_PAGE', 'main.php');
define('THUMB', 'thumb.png');
define('WIKI_EXTENSION', '.wiki');

//admin
define('ADMIN', 'admin');
define('PREVIEW', 'preview');
define('ADD', 0);
define('MODIFY', 1);
define('PARSE_WIKI', 'parse_wiki');

//urls
define('NEW_PUBLICATION', 'new_publication');
define('MODIFY_PUBLICATION', 'modify_publication');
define('PREVIEW_PUBLICATION', 'preview_publication');
define('PROCESS_PUBLICATION', 'process_publication');

//db connection
define('USER', 'admin');
define('HOST', 'localhost');
define('PORT', '3306');
define('PWD', 'H0n0Lulu43v3r');
define('DB_NAME', 'jeremieferreira');