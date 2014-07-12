<?php



namespace bablo\dao;

use bablo\model\Income;

/**
 *
 * @author andrii
 */
interface IncomeDAO extends DAO{
    function findAll($userId=0, $month=null, $year=null);
    function save(Income $income);
}
