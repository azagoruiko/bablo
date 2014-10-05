<?php
namespace bablo\controller;

use bablo\model\User;

class UserController extends BaseController {
    use serviceInject\UserServiceTrait;        
    function showUserAction() {
        $id = $this->getRequest()->getSessionValue('id');
        $this->view->user = $this->getUserService()->find($id);
        //require_once 'view/showUser.php';
        return 'showUser';
    }
    
    function createUserAction() {
        $name = $this->getRequest()->getPostValue('name');
        $pass = $this->getRequest()->getPostValue('pass');
        $repass = $this->getRequest()->getPostValue('re_pass');
        if ($pass !== $repass) {
            $this->view->error = "Passwords do not match";
            return 'editUser';
        }
        
        $user = new User();
        $user->setName($name);
        $user->setPass($pass);
        $this->view->user = $this->getUserService()->save($user);
        return 'showUser';
    }
    
    function loginAction() {
        $name = $this->getRequest()->getPostValue('name');
        $pass = $this->getRequest()->getPostValue('pass');
        if (empty($name) && empty($pass)) {
            return 'login';
        }
        else if (FALSE !== ($this->view->user = $this->getUserService()->authorize($name, $pass))) {
            $this->getRequest()->setSessionValue('id', $this->view->user->getId());
            return 'index_auth';
        } else {
            $this->view->error = "Login failed! You're a hacker!";
            return 'login';
        }
    }
    
    function indexAction() {
        return $this->isAuthorized() ? 'index_auth' : 'index';
    }
    
    function logoutAction() {
        $this->getRequest()->setSessionValue('id', NULL);
        return 'index';
    }
}
