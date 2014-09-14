<?php

session_start();
require_once './autoload.php';
require_once './config.php';

use bablo\controller\UserController;
use bablo\dao\MysqlConnection;
use bablo\dao\MysqlCurrencyDAO;
use bablo\dao\MysqlIncomeDAO;
use bablo\dao\MysqlUserDAO;
use bablo\layout\Layout;
use bablo\service\IncomeServiceImpl;
use bablo\service\UserServiceImpl;

MysqlConnection::$dbh = new PDO('mysql:host=' . Config::$dbhost . ';dbname=' .Config::$dbname, 
        Config::$dbuser, 
        Config::$dbpass);  
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($action)) {
    $action='index';
}
$ctrl = new UserController();
$ctrl->setUserService(new UserServiceImpl(new MysqlUserDAO()));
$ctrl->setIncomeService(new IncomeServiceImpl(new MysqlIncomeDAO()));
$ctrl->setCurrencyService(new MysqlCurrencyDAO());
$ctrl->setExpenceService(new bablo\dao\MysqlExpenceDAO());
if (isset($_SESSION['id'])) {
    $ctrl->setUserId($_SESSION['id']);
}
$layout = new Layout();
switch ($action) {
    case "showUser":
        $ctrl->setRequestParam('id', empty(filter_input(INPUT_GET, 'id')) ? $_SESSION['id'] : filter_input(INPUT_GET, 'id'));
        $viewName = $ctrl->showUser();
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "createUser" :
        $ctrl->setRequestParam('name', filter_input(INPUT_POST, 'name'));
        $ctrl->setRequestParam('pass', filter_input(INPUT_POST, 'pass'));
        $ctrl->setRequestParam('re_pass', filter_input(INPUT_POST, 're_pass'));
        $ctrl->createUser();
        break;
    case "login" :
        $ctrl->setRequestParam('name', filter_input(INPUT_POST, 'name'));
        $ctrl->setRequestParam('pass', filter_input(INPUT_POST, 'pass'));
        $viewName = $ctrl->login();
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "addIncome" :
        if (count($_POST) > 0) {
            foreach (['amount', 'currency_id', 'date', 'source_id', 'user_id'] as $key) {
                $ctrl->setRequestParam($key, filter_input(INPUT_POST, $key));
            }
            $viewName = $ctrl->addIncome();
        } else {
            $viewName = $ctrl->addIncome(false);
        }
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "newUser" :
        require_once 'view/editUser.php';
        break;
    case "addExpence" :
        if (count($_POST) > 0) {
            foreach (['amount', 'currency_id', 'date', 'source_id', 'user_id'] as $key) {
                $ctrl->setRequestParam($key, filter_input(INPUT_POST, $key));
            }
            $viewName = $ctrl->addExpence();
        } else {
            $viewName = $ctrl->addExpence(false);
        }
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "incomes" :
        $ctrl->setRequestParam('month', filter_input(INPUT_POST, 'months'));
        $viewName = $ctrl->incomes();
        
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "expences" :
        $ctrl->setRequestParam('month', filter_input(INPUT_POST, 'months'));
        $viewName = $ctrl->expences();
        
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "balance" :
        $ctrl->setRequestParam('month', filter_input(INPUT_POST, 'months'));
        $viewName = $ctrl->balance();
        
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "sumary" :
        $ctrl->setRequestParam('month', filter_input(INPUT_POST, 'months'));
        $viewName = $ctrl->sumary();
        
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "index" :
        $viewName = $ctrl->index();
        
        $layout->setView($ctrl->getView());
        
        $layout->render($viewName);
        break;
    case "google" :
        echo '<h1>hello </h1>';
        flush();
        header('location: http://www.google.com/');
        break;
    case "getIncomeUpdates":
        $ctrl->setRequestParam('since', filter_input(INPUT_GET, 'since'));
        $viewName = $ctrl->getIncomeUpdates();
        $layout->setView($ctrl->getView());
        $layout->setDisableLayout(1);
        $layout->render($viewName);
        break;
    default :
        http_response_code(404);
        echo "Page does not exist";
}
