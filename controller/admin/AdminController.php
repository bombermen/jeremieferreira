<?php

class AdminController {
    
    public static function isAdmin() {
        return isset($_SESSION['admin']);
    }
    
    private static function display403() {
        require './view/commons/403.html';
    }
    
    static function addPublication() {
        if(self::isAdmin()) {
            PublicationController::addModifyPublication(ADD);
        } else {
            self::display403();
        }
    }
    
    static function modifyPublication() {
        if(self::isAdmin()) {
            $action = MODIFY;
            require './view/admin/addModifyPublication.php';
        } else {
            self::display403();
        }
    }
    
    static function preview() {
        if(self::isAdmin()) {
            PublicationController::previewPublication();
        } else {
            self::display403();
        }
    }
    
    static function processPublication() {
        if(self::isAdmin()) {
            require './view/admin/processPublication.php';
        } else {
            self::display403();
        }
    }
    
    static function parseWiki() {
        if(self::isAdmin()) {
            require './view/admin/parseWiki.php';
        } else {
            self::display403();
        }
    }
}
