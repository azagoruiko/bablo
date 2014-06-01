<?php
namespace bablo\controller;

use bablo\model\Income;
use bablo\model\User;
use bablo\service\IncomeService;
use bablo\service\UserService;
use stdClass;

/**
 * Description of UserController
 *
 * @author andrii
 */
class UserController extends AbstractController {
    private $userService;
    private $incomeService;
    private $view;
    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }

        function __construct() {
            parent::__construct();
        $this->view = new stdClass();
    }

    
    function setUserService(UserService $service) {
        $this->userService = $service;
    }
    
    public function setIncomeService($incomeService) {
        $this->incomeService = $incomeService;
    }

        
    function showUser() {
        $id = $this->getRequestParam('id');
        $this->view->user = $this->userService->find($id);
        //require_once 'view/showUser.php';
        return 'showUser';
    }
    
    function createUser() {
        $view = new stdClass();
        $name = $this->getRequestParam('name');
        $pass = $this->getRequestParam('pass');
        $repass = $this->getRequestParam('re_pass');
        if ($pass !== $repass) {
            $view->error = "Passwords do not match";
            require_once 'view/editUser.php';
            return;
        }
        
        $user = new User();
        $user->setName($name);
        $user->setPass($pass);
        $view->user = $this->userService->save($user);
        require_once 'view/showUser.php';
    }
    
    function login() {
        $view = new stdClass();
        $name = $this->getRequestParam('name');
        $pass = $this->getRequestParam('pass');
        if (empty($name) && empty($pass)) {
            require_once 'view/login.php';
        }
        else if (FALSE !== ($view->user = $this->userService->authorize($name, $pass))) {
            //setcookie('id', $view->user->getId(), time()+60);
            $_SESSION['id'] = $view->user->getId();
            require_once 'view/showUser.php';
        } else {
            $view->error = "Login failed! You're a hacker!";
            require_once 'view/login.php';
        }
    }
    
    function addIncome() {
        $income = new Income();
        $income->setAmount($this->getRequestParam('amount'));
        $income->setCurrency($this->getRequestParam('currency'));
        $income->setDate($this->getRequestParam('date'));
        $income->setSource($this->getRequestParam('source'));
        $income->setUserid($_SESSION['id']);
        
        $this->incomeService->save($income);
    }
}
