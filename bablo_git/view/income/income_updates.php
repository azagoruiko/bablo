<?php
foreach ($this->view->updates as $income) {
    echo "<tr id=\"am_{$income->getId()}\"><td>{$income->getId()}</td><td>{$income->getDate()}</td><td>{$income->getAmount()}</td><td></td><td></td></tr>";
}
?>