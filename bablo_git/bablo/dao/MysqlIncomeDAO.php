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
        $stmt = MysqlConnection::$dbh->prepare("SELECT i.*, c.name as currency, (i.amount*rate) as usdAmount "
                . "from income i "
                . "join currency c "
                . "on i.currency_id=c.id "
                . "join rate r "
                . "on r.id=c.id and r.date=(select MAX(rate.date) as d from rate) "
                . "where i.user_id=:user_id "
                . "and i.date between :date_from and LAST_DAY(:date_from) "
                . "order by i.date");
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('date_from', $dateFrom);
        $stmt->execute();
        $incomes = [];
        while ($income = $stmt->fetchObject('\bablo\model\Income')) {
            $incomes[] = $income;
        }
        return $incomes;
    }
    
    public function getUpdates($userId=0, $lastId=0) {
        $stmt = MysqlConnection::$dbh->prepare("SELECT i.*, c.name as currency, (i.amount*rate) as usdAmount "
                . "from income i "
                . "join currency c "
                . "on i.currency_id=c.id "
                . "join rate r "
                . "on r.id=c.id and r.date=(select MAX(rate.date) as d from rate) "
                . "where i.user_id=:user_id and i.id > :last_id "
                . "order by i.date");
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('last_id', intval($lastId));
        $stmt->execute();
        $incomes = [];
        while ($income = $stmt->fetchObject('\bablo\model\Income')) {
            $incomes[] = $income;
        }
        return $incomes;
    }

    public function getCombinedReport ($userId=0, $month=null, $year=null){
        if (empty($month) || empty($year)) {
            list($month, $year) = explode(',', date('m,Y'));
        }
        $dateFrom = date('Y-m-d', mktime(0,0,0,$month, 1, $year));
        $dateTo = date('Y-m-d', mktime(0,0,0,++$month, 1, $year));
        $stmt = MysqlConnection::$dbh->prepare(
                "select type, balance, user_id, date, currency, usdAmount from ("
                . "(SELECT 1 as type, e.amount*-1 as balance, e.user_id, e.date, c.name as currency, (e.amount*rate*-1) as usdAmount "
                . "from expence e "
                . "join currency c "
                ."on e.currency_id=c.id "
                . "join rate r "
                . "on r.id=c.id and r.date=(select MAX(rate.date) as d from rate) "
                . "where e.user_id=:user_id "
                . "and e.date between :date_from and LAST_DAY(:date_from)) "

                ."UNION "

                . "(SELECT 0 as type, i.amount, i.user_id, i.date, c.name as currency, (i.amount*rate) as usdAmount "
                . "from income i "
                . "join currency c "
                . "on i.currency_id=c.id "
                . "join rate r "
                . "on r.id=c.id and r.date=(select MAX(rate.date) as d from rate) "
                . "where i.user_id=:user_id "
                . "and i.date between :date_from and LAST_DAY(:date_from)) "
                . ") as balanceTable "
                . "order by date "
                );
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('date_from', $dateFrom);
        $stmt->bindParam('date_to', $dateTo);
        $stmt->execute();
        $balance = [];
        while ($balanc = $stmt->fetch (\PDO::FETCH_ASSOC)) {
            $balance[] = $balanc;
        }
        return $balance;
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
