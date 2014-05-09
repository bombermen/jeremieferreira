<?php

/**
 * Description of Connection
 *
 * @author Jeremie Ferreira
 */
class Connection {
    private static $_instance;
    
    public function __construct() { }
    
    /**
     * @return PDO connection
     */
    public static function getConnection()
    {
        if( !isset( self::$_instance ) )
        {
            try
            {
                $pdo = new PDO('mysql:host='.HOST.
                                            ';dbname='.DB_NAME.
                                            ';port='.PORT,
                                            USER,
                                            PWD,
                                            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                
                //show query error
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                
                self::$_instance = $pdo;
            } catch (Exception $ex) {
                $logger = Logger::getRootLogger();
                $logger->error($ex->getMessage());
                die();
            }
        }   
        return self::$_instance;
    }
}

