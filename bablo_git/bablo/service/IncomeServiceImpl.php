<?php

namespace bablo\service;

use bablo\dao\IncomeDAO;
use bablo\model\Income;

/**
 * Description of IncomeServiceImpl
 *
 * @author andrii
 */
class IncomeServiceImpl implements IncomeService {
    private $dao;
    function __construct(IncomeDAO $dao) {
        $this->dao = $dao;
    }

    
    public function find($id) {
        return $this->dao->find($id);
    }

    public function findAll() {
        return $this->dao->findAll();
    }

    public function save(Income $income) {
        return $this->dao->save($income);
    }

//put your code here
}
