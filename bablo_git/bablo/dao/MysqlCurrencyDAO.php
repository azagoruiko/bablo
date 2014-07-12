<?php

namespace bablo\dao;

/**
 * Description of MysqlCurrencyDAO
 *
 * @author andrii
 */
class MysqlCurrencyDAO implements CurrencyDAO {
    public function findAll() {
        $stmt = MysqlConnection::$dbh->prepare('SELECT * from currency');
        $stmt->execute();
        $currencies = [];
        while (FALSE !== ($obj = $stmt->fetch())) {
            $currencies[] = $obj;
        }
        return $currencies;
    }
}
