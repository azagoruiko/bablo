<?php
namespace bablo\controller;

use bablo\model\Expence;

class ExpenceController extends BaseMoneyController {
    use serviceInject\ExpenceServiceTrait;
    function addExpenceAction($add = true) {
        $expence = new Expence();
        if ($add) {
            $expence->setAmount($this->getRequestParam('amount'));
            $expence->setCurrency_id($this->getRequestParam('currency_id'));
            $expence->setDate($this->getRequestParam('date'));
            $expence->setSource($this->getRequestParam('source_id'));
            $expence->setUserid($_SESSION['id']);

            $this->getExpenceService()->save($expence);
        }
        $this->view->currencies = $this->getCurrencyService()->findAll();
        return 'editExpence';
    }
    
    function expencesAction() {
        $this->view->message = '';
        if (empty($this->getUserId())) {
            $this->view->message = 'you\'re not authorized, go away!';
            $this->view->expences = [];
        } else {
            list($month, $year)=$this->getSelectedYearMonth();
            $this->view->expences = $this->getExpenceService()->findAll($this->getUserId(), $month, $year);
            $this->prepareMoneyReportForm();
        }
        return 'expences';
    }
    
}
