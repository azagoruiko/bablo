<?php
namespace bablo\model;

/**
 * Description of Income
 *
 * @author andrii
 */
class Income {
    private $id;
    private $amount;
    private $currency;
    private $userid;
    private $source;
    private $date;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

        public function getAmount() {
        return $this->amount;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getSource() {
        return $this->source;
    }

    public function getDate() {
        return $this->date;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function setDate($date) {
        $this->date = $date;
    }
    
}
