<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace bablo\dao;

use bablo\model\Expence;

/**
 * Description of MysqlExpenceDAO
 *
 * @author Денис
 */
class MysqlExpenceDAO implements ExpenceDAO {
    public function find($id) {
        
    }

    public function findAll($userId=0, $month=null, $year=null) {
        if (empty($month) || empty($year)) {
            list($month, $year) = explode(',', date('m,Y'));
        }
        $dateFrom = date('Y-m-d', mktime(0,0,0,$month, 1, $year));
        $dateTo = date('Y-m-d', mktime(0,0,0,++$month, 1, $year));
        $stmt = MysqlConnection::$dbh->prepare("SELECT e.*, c.name as currency, (e.amount*rate) as usdAmount "
                . "from expence e "
                . "join currency c "
                . "on e.currency_id=c.id "
                . "join rate r "
                . "on r.id=c.id and r.date=(select MAX(rate.date) as d from rate) "
                . "where e.user_id=:user_id "
                . "and e.date between :date_from and :date_to "
                . "order by e.date");
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('date_from', $dateFrom);
        $stmt->bindParam('date_to', $dateTo);
        $stmt->execute();
        $expences = [];
        while ($expence = $stmt->fetchObject('\bablo\model\Expence')) {
            $expences[] = $expence;
        }
        return $expences;
    }

    public function save(Expence $income) {
        $stmt = MysqlConnection::$dbh->prepare("INSERT INTO expence "
                . "(date, amount, currency_id, user_id) "
                . "values "
                . "(:date, :amount, :currency_id, :user_id)");
        $stmt->bindParam('user_id', $income->getUserid());
        $stmt->bindParam('date', $income->getDate());
        $stmt->bindParam('amount', $income->getAmount());
        $stmt->bindParam('currency_id', $income->getCurrency_id());
        return $stmt->execute();
    }
}
