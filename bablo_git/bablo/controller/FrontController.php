<?php
namespace bablo\controller;

use bablo\util\MySQL;
use bablo\util\Request;
use bablo\util\View;
use PDO;

class FrontController {
    private $view;
    function start() {
        MySQL::$db = new PDO('mysql:host=localhost;dbname=' . \Config::$dbname, \Config::$dbuser, \Config::$dbpass);
        
        $this->view = new View();
        session_start();
        $r = new Request();
        $ctrlName = $r->getGetValue('ctrl');
        if (empty($ctrlName)) {
            $ctrlName = 'user';
        }
        
        $action = $r->getGetValue('action');
        if (empty($action)) {
            $action = 'index';
        }
        
        if (!$r->isAuthorized() && (
                in_array("$ctrlName/$action", \Config::$authRequiredActions)
                || in_array("$ctrlName/*", \Config::$authRequiredActions))) {
            $ctrlName = 'user';
            $action = 'index';
        }
        
        switch ($ctrlName) {
            case 'user':
                $ctrl = new UserController($this->view);
                break;
            case 'income':
                $ctrl = new IncomeController($this->view);
                break;
            case 'expence':
                $ctrl = new ExpenceController($this->view);
                break;
            case 'currency':
                $ctrl = new CurrencyController($this->view);
                break;
            default:
                http_response_code(404);
        }
        
        $layOut = new \bablo\layout\Layout();
        $ctrl->setLayout($layOut);
        
        $view = $ctrl->{"{$action}Action"}();
        
        $layOut->setCtrlName($ctrlName);
        $layOut->setView($this->view);
        $layOut->render($view);
    }
}
