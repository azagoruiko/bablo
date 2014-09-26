<?php
namespace bablo\controller;

use bablo\util\Request;

class BaseController {
    /**
     *
     * @var Request
     */
    private $request;
    protected $view;
    
    public function getUserId() {
        return $this->getRequest()->getSessionValue('id');
    }

    public function setUserId($userId) {
        $this->getRequest()->setSessionValue('id', $userId);
    }
    
    function __construct($view) {
        $this->view = $view;
    }
    
     /**
     * 
     * @return Request
     */
    protected function getRequest() {
        if (empty($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }
    
    protected function redirect($where) {
        header("location: $where.php");
    }
}
