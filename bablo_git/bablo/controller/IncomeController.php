<?php
namespace bablo\controller;

use bablo\model\Income;

class IncomeController extends BaseMoneyController {
    use serviceInject\CurrencyServiceTrait;
    use serviceInject\IncomeServiceTrait;
    
    function addIncomeAction($add = true) {
        $income = new Income();
        if ($add) {
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
        $this->view->updates = $this->getIncomeService()->getUpdates($this->getUserId(), $this->getRequestParam('since'));
        return 'income_updates';
    }
}
