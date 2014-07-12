<?php

namespace bablo\dao;

class MysqlIncomeDAO implements IncomeDAO {
    public function find($id) {
        
    }

    public function findAll($userId=0, $month=null, $year=null) {
        if (empty($month) || empty($year)) {
            list($month, $year) = explode(',', date('m,Y'));
        }
        $dateFrom = date('Y-m-d', mktime(0,0,0,$month, 1, $year));
        $dateTo = date('Y-m-d', mktime(0,0,0,++$month, 1, $year));
        $stmt = MysqlConnection::$dbh->prepare("SELECT i.*, c.name as currency "
                . "from income i "
                . "join currency c "
                . "on i.currency_id=c.id "
                . "where i.user_id=:user_id "
                . "and date between :date_from and :date_to");
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('date_from', $dateFrom);
        $stmt->bindParam('date_to', $dateTo);
        $stmt->execute();
        $incomes = [];
        while ($income = $stmt->fetchObject('\bablo\model\Income')) {
            $incomes[] = $income;
        }
        return $incomes;
    }

    public function save(\bablo\model\Income $income) {
        $stmt = MysqlConnection::$dbh->prepare("INSERT INTO income "
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
