<?php
namespace bablo\controller;

use bablo\model\Income;

class IncomeController extends BaseMoneyController {
    use serviceInject\CurrencyServiceTrait;
    use serviceInject\IncomeServiceTrait;
    
    function addIncomeAction() {
        $income = new Income();
        if ($this->getRequest()->isPost()) {
            $income->setAmount($this->getRequest()->getPostValue('amount'));
            $income->setCurrency_id($this->getRequest()->getPostValue('currency_id'));
            $income->setDate($this->getRequest()->getPostValue('date'));
            $income->setSource($this->getRequest()->getPostValue('source_id'));
            $income->setUserid($this->getRequest()->getSessionValue('id'));

            $this->getIncomeService()->save($income);
        }
        $this->view->currencies = $this->getCurrencyService()->findAll();
        return 'editIncome';
    }
    
    function incomesAction() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->incomes = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->incomes = $this->getIncomeService()->findAll($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'incomes';
    }
    
    function balanceAction() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->balance = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->balance = $this->getIncomeService()->getCombinedReport ($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'balance';
    }
    
    function sumaryAction() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->sumary = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->sumary = $this->getIncomeService()->getSumary ($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'sumary';
    }
    
    function getIncomeUpdatesAction() {
        $this->getLayout()->setDisableLayout(true);
        $dates = $this->getSelectedYearMonth();
        $this->view->updates = $this->getIncomeService()->getUpdates(
                $this->getUserId(), 
                $this->getRequest()->getPostValue('since'),
                $dates[0], $dates[1]);
        return 'income_updates';
    }
    
    function getIncomeUpdatesJSONAction() {
        $this->getLayout()->setDisableLayout(true);
        $dates = $this->getSelectedYearMonth();
        $this->view->updates = $this->getIncomeService()->getUpdates(
                $this->getUserId(), 
                $this->getRequest()->getPostValue('since'),
                $dates[0], $dates[1]);
        $maxId = $this->getRequest()->getPostValue('since');
        foreach ($this->view->updates as $update) {
            if ($maxId < $update->getId()) {
                $maxId = $update->getId();
            }
        }
        $this->view->maxId = $maxId;
        return 'income_updates_json';
    }
    
    function deleteAction() {
        $this->getLayout()->setDisableLayout(true);
        $id = $this->getRequest()->getPostValue('id');
        try {
            $this->view->result = $this->getIncomeService()->delete($id);
        } catch (Exception $e) {
            http_response_code(500);
            $this->view->result = -1;
        }
        
        return 'income_updates_json';
    }
    
    function monthlyIncomeAction() {
        $this->getLayout()->setDisableLayout(true);
        $month = date("m");
        $year = date("Y");
        $this->view->updates = $this->getIncomeService()->getUpdates(
                $this->getUserId(), 
                0,
                $month, $year);
        return 'income_updates_json';
    }
    
    function annualBalanceAction() {
        $this->getLayout()->setDisableLayout(true);
        $year = date("Y");
        $this->view->updates = $this->getIncomeService()->getAnnualBalance ($this->getUserId(), $year);
        
        return 'income_updates_json';
    }
    
    function revenue12MonthsAction() {
        $this->getLayout()->setDisableLayout(true);
        $this->view->revenue = $this->getIncomeService()->getRevenueBrokenByMonth ($this->getUserId());
        
        return 'income_updates_json';
    }
}
