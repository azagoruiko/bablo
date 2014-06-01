<?php



namespace bablo\dao;

use bablo\model\Income;

/**
 *
 * @author andrii
 */
interface IncomeDAO extends DAO{
    function findAll();
    function save(Income $income);
}
