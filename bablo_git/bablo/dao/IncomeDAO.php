<?php



namespace bablo\dao;

use bablo\model\Income;

/**
 *
 * @author andrii
 */
interface IncomeDAO extends DAO{
    function findAll($userId=0);
    function save(Income $income);
}
