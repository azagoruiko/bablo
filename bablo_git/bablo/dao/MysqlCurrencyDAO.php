<?php

namespace bablo\dao;

use bablo\util\MySQL;

/**
 * Description of MysqlCurrencyDAO
 *
 * @author andrii
 */
class MysqlCurrencyDAO implements CurrencyDAO {
    public function findAll() {
        $stmt = MySQL::$db->prepare('SELECT * from currency');
        $stmt->execute();
        $currencies = [];
        while (FALSE !== ($obj = $stmt->fetch())) {
            $currencies[] = $obj;
        }
        return $currencies;
    }
}
