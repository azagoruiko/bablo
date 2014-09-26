<?php

namespace bablo\controller\serviceInject;

use bablo\dao\MysqlIncomeDAO;
use bablo\service\IncomeServiceImpl;

trait IncomeServiceTrait {
    private $incomeService;
    
    /**
     * 
     * @return \bablo\service\IncomeService  Description
     */
    public function getIncomeService() {
        if ($this->incomeService === null) {
            $this->incomeService = new IncomeServiceImpl(new MysqlIncomeDAO());
        }
        return $this->incomeService;
    }


}
