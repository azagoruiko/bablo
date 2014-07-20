<?php
namespace bablo\controller;

use bablo\dao\CurrencyDAO;
use bablo\dao\ExpenceDAO;
use bablo\model\Expence;
use bablo\model\Income;
use bablo\model\User;
use bablo\service\UserService;
use stdClass;

/**
 * Description of UserController
 *
 * @author andrii
 */
class UserController extends AbstractController {
    private $userService;
    /**
     *
     * @var \bablo\service\IncomeServiceImpl
     */
    private $incomeService;
    private $currencyService;
    private $view;
    private $expenceService;
    
    private $userId = null;
    
    public function getCurrencyService() {
        return $this->currencyService;
    }

    public function setCurrencyService(CurrencyDAO $currencyService) {
        $this->currencyService = $currencyService;
    }
    public function getExpenceService() {
        return $this->expenceService;
    }

    public function setExpenceService(ExpenceDAO $expenceService) {
        $this->expenceService = $expenceService;
    }

            
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

        
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
            return 'login';
        }
        else if (FALSE !== ($this->view->user = $this->userService->authorize($name, $pass))) {
            //setcookie('id', $view->user->getId(), time()+60);
            $_SESSION['id'] = $this->view->user->getId();
            return 'showUser';
        } else {
            $view->error = "Login failed! You're a hacker!";
            return 'login';
        }
    }
    
    function addIncome($add = true) {
        $income = new Income();
        if ($add) {
            $income->setAmount($this->getRequestParam('amount'));
            $income->setCurrency_id($this->getRequestParam('currency_id'));
            $income->setDate($this->getRequestParam('date'));
            $income->setSource($this->getRequestParam('source_id'));
            $income->setUserid($_SESSION['id']);

            $this->incomeService->save($income);
        }
        $this->view->currencies = $this->getCurrencyService()->findAll();
        return 'editIncome';
    }
    
    private function getSelectedMonth($year, $month) {
        $selectedMonth = $this->getRequestParam('month');
        if (empty($selectedMonth)) {
            $selectedMonth = implode(',', [$month, $year]);
        }
        return $selectedMonth;
    }
    
    private function getMonthArray($year, $month) {
        $months = [];
        for ($i=0; $i<=12; $i++){
            $months["$month,$year"]=date("M", mktime(0, 0, 0, $month, 1, $year))." $year";
            $month--;
            if ($month==0) {
                $month=12;
                $year--;
            }
        }
        return $months;
    }
    
    private function getSelectedYearMonth() {
        $month = $this->getRequestParam('month');
        if (empty($month)) {
            return [null, null];
        } else {
            return explode(',', $this->getRequestParam('month'));
        }
    }
    
    private function getTodayYearMonth() {
        $today = date ('Y,m');
        return explode(',', $today);
    }
    
    private function prepareMoneyReportForm() {
        list($year, $month)=$this->getTodayYearMonth();
        $this->view->selectedMonth = $this->getSelectedMonth($year, $month);
        $this->view->months = $this->getMonthArray($year, $month);
    }
    
    
    function addExpence($add = true) {
        $expence = new Expence();
        if ($add) {
            $expence->setAmount($this->getRequestParam('amount'));
            $expence->setCurrency_id($this->getRequestParam('currency_id'));
            $expence->setDate($this->getRequestParam('date'));
            $expence->setSource($this->getRequestParam('source_id'));
            $expence->setUserid($_SESSION['id']);

            $this->expenceService->save($expence);
        }
        $this->view->currencies = $this->getCurrencyService()->findAll();
        return 'editExpence';
    }
    
    function incomes() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->incomes = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->incomes = $this->incomeService->findAll($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'incomes';
    }
    
    
    function expences() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->expences = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->expences = $this->expenceService->findAll($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'expences';
    }
    
    function balance() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->balance = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->balance = $this->incomeService->getCombinedReport ($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'balance';
    }
    
    function sumary() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->sumary = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->sumary = $this->incomeService->getSumary ($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'sumary';
    }
    
    function index() {
        return 'index';
    }
}
