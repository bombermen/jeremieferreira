<?php

/**
 * Description of Connection
 *
 * @author Jeremie Ferreira
 */
class Connection {
    private static $_instance;
    
    public function __construct() { }
    
    const USER = 'root';
    const HOST = 'localhost';
    const PWD = '';
    const DB = 'jeremieferreira';
    
    /**
     * @return PDO connection
     */
    public static function getConnection()
    {
        if( !isset( self::$_instance ) )
        {
            try
            {
                self::$_instance = new PDO('mysql:host='.self::HOST.
                                            ';dbname='.self::DB,
                                            self::USER,
                                            self::PWD,
                                            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                
            } catch (Exception $ex) {
                $logger = Logger::getLogger();
                $logger->error($ex->getCode().':'.$ex->getMessage());
                die();
            }
        }   
        return self::$_instance;
    }
}

