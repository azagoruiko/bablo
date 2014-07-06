<?php

session_start();
require_once './autoload.php';
require_once './config.php';

use bablo\controller\UserController;
use bablo\dao\MysqlIncomeDAO;
use bablo\dao\MysqlUserDAO;
use bablo\dao\MysqlConnection;
use bablo\layout\Layout;
use bablo\service\IncomeServiceImpl;
use bablo\service\UserServiceImpl;

MysqlConnection::$dbh = new PDO('mysql:host=' . Config::$dbhost . ';dbname=' .Config::$dbname, 
        Config::$dbuser, 
        Config::$dbpass);  
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$ctrl = new UserController();
$ctrl->setUserService(new UserServiceImpl(new MysqlUserDAO()));
$ctrl->setIncomeService(new IncomeServiceImpl(new MysqlIncomeDAO()));
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
    case "addincome" :
        if (count($_POST) > 0) {
            foreach (['amount', 'currency', 'date', 'source', 'user_id'] as $key) {
                $ctrl->setRequestParam($key, filter_input(INPUT_POST, $key));
            }
            $ctrl->addIncome();
        }
        require_once 'view/editIncome.php';
        break;
    case "newUser" :
        require_once 'view/editUser.php';
        break;
    case "incomes" :
        $viewName = $ctrl->incomes();
        
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    case "google" :
        echo '<h1>hello </h1>';
        flush();
        header('location: http://www.google.com/');
        break;
    default :
        http_response_code(404);
        echo "Page does not exist";
}