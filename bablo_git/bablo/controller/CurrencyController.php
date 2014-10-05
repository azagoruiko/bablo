<?php

namespace bablo\controller;

class CurrencyController extends BaseController {
    use serviceInject\CurrencyServiceTrait;
    
    function setRatesAction() {
        $this->view->currencies = $this->getCurrencyService()->findAll();
        return 'set_rates';
    }
}
