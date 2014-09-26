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
<table>
<?php
    $usdAmountExpence=0;
    $usdAmountIncome=0;
    
    foreach ($this->view->sumary as $income) {
        $usdAmountExpence+=$income['expence'];
        $usdAmountIncome+=$income['income'];
        
        echo "<tr><td>{$income['balance']}</td>"
        . "<td>{$income['income']}</td>"
        . "<td>{$income['expence']}</td>"
        . "<td>{$income['month']}</td>"
        . "<td>{$income['year']}</td>"
        . "</tr>";
    }
    
?>
</table>
<div>Total USD Amount Income: <?php echo round($usdAmountIncome,2);?></div>
<div>Total USD Amount Expence: <?php echo round($usdAmountExpence,2);?></div>
<div>Total USD Amount Balance: <?php echo round($usdAmountIncome,2)+round($usdAmountExpence,2);?></div>
<div style="color:red;"><?php echo $this->view->message; ?></div>
