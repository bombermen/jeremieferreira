<?php

//global settings
require './config/config.php';

//commons
//  Menu item generation
require './controller/commons/menuController.php';
//  Dispatcher
require './controller/commons/Dispatcher.php';

//admin
require './controller/admin/AdminController.php';

//utilities
require './controller/utils/Utils.php';
require './controller/utils/PublicationController.php';

//libs
//  log4php
require 'libs/log4php/Logger.php';
Logger::configure('config/log4php.xml');
//  wiky
require './libs/wiky/wiky.inc.php';

//dao connection
require './model/include_dao.php';
 
