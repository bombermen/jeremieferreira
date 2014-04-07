<?php

/**
 * Description of Connection
 *
 * @author Jeremie Ferreira
 */
class Connection {
    private static $_instance;
    
    public function __construct() { }
    
    const USER = 'admin';
    const HOST = 'localhost';
    const PORT = '3306';
    const PWD = 'H0n0Lulu43v3r';
    const DB_NAME = 'jeremieferreira';
    
    /**
     * @return PDO connection
     */
    public static function getConnection()
    {
        if( !isset( self::$_instance ) )
        {
            try
            {
                $pdo = new PDO('mysql:host='.self::HOST.
                                            ';dbname='.self::DB_NAME.
                                            ';port='.self::PORT,
                                            self::USER,
                                            self::PWD,
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

