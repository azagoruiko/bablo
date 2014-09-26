<?php

namespace bablo\controller\serviceInject;

use bablo\dao\MysqlUserDAO;
use bablo\service\UserService;
use bablo\service\UserServiceImpl;

trait UserServiceTrait {
    private $userService;
    
    /**
     * 
     * @return UserService Description
     */
    public function getUserService() {
        if ($this->userService === null) {
            $this->userService = new UserServiceImpl(new MysqlUserDAO());
        }
        return $this->userService;
    }

}
