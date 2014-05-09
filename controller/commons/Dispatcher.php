<?php

class Dispatcher {

    static function dispatch() {
        //session_start();

        $url = urldecode($_SERVER['REQUEST_URI']);
        $url = rtrim($url, '/');
        $explodedUrl = explode('/', $url);
        $extension = explode($url, '.');
        $extension = end($extension);
        $urlElements = count($explodedUrl);

        if ($urlElements <= URL_BEGIN) {
            require './controller/HomeController.php';
        } else if ($urlElements == URL_BEGIN + 1) {
            $_SESSION['admin'] = true;
            //admin
            if ($explodedUrl[URL_BEGIN] == NEW_PUBLICATION) {
                AdminController::addPublication();
            } else if ($explodedUrl[URL_BEGIN] == PREVIEW) {
                AdminController::preview();
            } else if ($explodedUrl[URL_BEGIN] == PROCESS_PUBLICATION) {
                AdminController::processPublication();
            } else if ($explodedUrl[URL_BEGIN] == PARSE_WIKI) {
                AdminController::parseWiki();
            } else if (in_array($explodedUrl[URL_BEGIN], $GLOBALS['CATEGORIES'])) {
                $category = $explodedUrl[URL_BEGIN];
                require './view/commons/categoryHome.php';
            }
        } else {
            PublicationController::displayPublicationPage($url);
        }
    }

}
