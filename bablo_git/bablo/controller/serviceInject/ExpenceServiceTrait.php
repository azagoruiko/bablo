<?php

namespace bablo\controller\serviceInject;

use bablo\dao\MysqlExpenceDAO;

trait ExpenceServiceTrait {
    private $expenceService;
    
    /**
     * 
     * @return \bablo\dao\ExpenceDAO Description
     */
    
    public function getExpenceService() {
        if ($this->expenceService === null) {
            $this->expenceService = new MysqlExpenceDAO();
        }
        return $this->expenceService;
    }


}
