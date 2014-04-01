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
        var_dump(DAOFactory::getPersonDAO()->load(1));
        var_dump(DAOFactory::getPersonDAO()->load(3));
        
        ?>
    </body>
</html>
