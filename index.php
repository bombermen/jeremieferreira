<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <!-- log4php -->
        <?php
            include('libs/log4php/Logger.php');
            Logger::configure('libs/log4php.xml');
        ?>
        
        <!-- db connection -->
        <?php
        require './model/include_dao.php';
        ?>
        
        <?php
        $file = '/fdsfds/wbcbw/sdfs.g';
        $file = explode('/', $file);
        echo end($file);
        $d = new DateTime();
        $person = new Person(array('name' => 'John Jacob', 'surname' => 'Doe', 'birthdate' => $d->getTimestamp()));
        
        DAOFactory::getPersonDAO()->insert($person);
        $persons = DAOFactory::getPersonDAO()->selectAll();
        
        var_dump($persons);
        ?>
    </body>
</html>
