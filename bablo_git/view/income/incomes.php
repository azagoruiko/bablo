<form method="post" action="">
    <select name="months">
        <?php
            $selected = '';
            foreach ($this->view->months as $key=>$value){
                if ($this->view->selectedMonth==$key){$selected=' selected';}
                echo "<option$selected value=\"$key\">$value</option>";
                $selected='';
            }
            
        ?>
    </select>
    <input type="submit"/>
</form>
<div>Selected month: <?php echo $this->view->months[$this->view->selectedMonth];?></div>
<table id="incomes_table" class="table table-striped table-bordered table-condensed">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Currency</th>
        <th>USD Amount</th>
        
        
    </tr>
<?php
    $usdAmount=0;
    
    foreach ($this->view->incomes as $income) {
        $usdAmount+=$income->getUsdAmount();
        $curentUsdAmount=round($income->getUsdAmount(),2);
        echo "<tr><td>{$income->getId()}</td>"
        . "<td>{$income->getDate()}</td>"
        . "<td>{$income->getAmount()}</td>"
        . "<td>{$income->getCurrency()}</td>"
        . "<td>\${$curentUsdAmount}</td>"
        . "</tr>";
    }
    
?>
</table>
<div id="new_content"></div>
<div>Total USD Amount: <?php echo round($usdAmount,2);?></div>
<div style="color:red;"><?php echo $this->view->message; ?></div>
<script src="js/main.js"></script>