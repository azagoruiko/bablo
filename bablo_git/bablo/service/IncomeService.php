<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace bablo\service;

use bablo\model\Income;

/**
 *
 * @author andrii
 */
interface IncomeService {
    function save(Income $income);
    function findAll($userId);
    function find($id);
}
