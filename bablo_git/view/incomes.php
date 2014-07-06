<table>
<?php
    foreach ($this->view->incomes as $income) {
        echo "<tr><td>{$income->getId()}</td>"
        . "<td>{$income->getDate()}</td>"
        . "<td>{$income->getAmount()}</td>"
        . "<td>{$income->getCurrency()}</td>"
        . "</tr>";
    }
?>
</table>
<div style="color:red;"><?php echo $this->view->message; ?></div>
