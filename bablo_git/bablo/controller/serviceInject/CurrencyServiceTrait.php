<?php
namespace bablo\controller\serviceInject;

use bablo\dao\MysqlCurrencyDAO;

trait CurrencyServiceTrait {
    private $currencyService;
    
    /**
     * 
     * @return \bablo\dao\CurrencyDAO
     */
    public function getCurrencyService() {
        if ($this->currencyService === null) {
            $this->currencyService = new MysqlCurrencyDAO();
        }
        return $this->currencyService;
    }


}
