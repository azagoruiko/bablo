<?php

use bablo\controller\FrontController;
use bablo\util\MySQL;
require_once './autoload.php';
require_once './config.php';

MySQL::$db = new PDO('mysql:host=' . Config::$dbhost . ';dbname=' .Config::$dbname, 
        Config::$dbuser, 
        Config::$dbpass);  

if (isset($_SESSION['id'])) {
    $ctrl->setUserId($_SESSION['id']);
}

$layout = new bablo\layout\Layout();
$fc = new FrontController();
$fc->start();
