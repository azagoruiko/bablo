<?php

namespace bablo\dao;

class MysqlIncomeDAO implements IncomeDAO {
    public function find($id) {
        
    }

    public function findAll($userId=0) {
        $stmt = MysqlConnection::$dbh->prepare("SELECT i.*, c.name as currency from income i join currency c on i.currency_id=c.id where i.user_id=:user_id");
        $stmt->bindParam('user_id', $userId);
        $stmt->execute();
        $incomes = [];
        while ($income = $stmt->fetchObject('\bablo\model\Income')) {
            $incomes[] = $income;
        }
        return $incomes;
    }

    public function save(\bablo\model\Income $income) {
        
    }

}
