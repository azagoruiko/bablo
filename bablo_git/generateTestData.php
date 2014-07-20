<?php

require_once './autoload.php';
require_once './config.php';

use bablo\dao\MysqlConnection;
use bablo\dao\MysqlCurrencyDAO;
use bablo\dao\MysqlIncomeDAO;
use bablo\dao\MysqlUserDAO;
use bablo\service\IncomeServiceImpl;
use bablo\service\UserServiceImpl;

MysqlConnection::$dbh = new PDO('mysql:host=' . Config::$dbhost . ';dbname=' .Config::$dbname, 
        Config::$dbuser, 
        Config::$dbpass);  


$ctrl = new stdClass();
$ctrl->userService = new UserServiceImpl(new MysqlUserDAO());
$ctrl->incomeService = new IncomeServiceImpl(new MysqlIncomeDAO());
$ctrl->currencyService = new MysqlCurrencyDAO();
$ctrl->expenceService = new bablo\dao\MysqlExpenceDAO();


$date1 = date ("d.m.Y");
$date2  = date("d.m.Y", mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-1));
     
list($d,$m,$y) = explode(".",$date1);
$time1 = mktime(0,0,0,$m,$d,$y);
list($d,$m,$y) = explode(".",$date2);
$time2 = mktime(0,0,0,$m,$d,$y);

for ($i = $time1; $i >= $time2; $i-=24*60*60) {
   
    $timesGot = rand(2,4);
    
    for ($j=1; $j<=$timesGot; $j++){
        $income = new \bablo\model\Income();

        $amount = rand(30,60)*10;
        $income->setAmount($amount);

        $curency = rand(1,3);
        $income->setCurrency_id($curency);

        $date = date ("Y-m-d", $i);
        $income->setDate($date);

        $source_id = "something";
        $income->setSource($source_id);

        $income->setUserid(3);

        $ctrl->incomeService->save($income);
    }
    
    $timesSpent = rand(2,3);
    
    for ($j=1; $j<=$timesSpent; $j++){
        $expence = new \bablo\model\Expence();

        $amount = rand(5,50)*10;
        $expence->setAmount($amount);

        $curency = rand(1,3);
        $expence->setCurrency_id($curency);

        $date = date ("Y-m-d", $i);
        $expence->setDate($date);

        $source_id = "something";
        $expence->setSource($source_id);

        $expence->setUserid(3);

        $ctrl->expenceService->save($expence);
    }
        
}
