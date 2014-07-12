<form method="post" action="">
    <select name="months">
        <?php
            foreach ($this->view->months as $key=>$value){
                echo "<option value=\"$key\">$value</option>";
            }
        ?>
    </select>
    <input type="submit"/>
</form>
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
