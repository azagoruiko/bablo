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
    
    foreach ($this->view->balance as $income) {
        if ($income['type']==1) {
            $usdAmountExpence+=$income['usdAmount'];
            $curentUsdAmount=round($income['usdAmount'],2);
        }else{
            $usdAmountIncome+=$income['usdAmount'];
            $curentUsdAmount=round($income['usdAmount'],2);
        }
        echo "<tr><td>{$income['balance']}</td>"
        . "<td>{$income['date']}</td>"
        . "<td>{$income['currency']}</td>"
        . "<td>\${$curentUsdAmount}</td>"
        . "</tr>";
    }
    
?>
</table>
<div>Total USD Amount Income: <?php echo round($usdAmountIncome,2);?></div>
<div>Total USD Amount Expence: <?php echo round($usdAmountExpence,2);?></div>
<div>Total USD Amount Balance: <?php echo round($usdAmountIncome,2)+round($usdAmountExpence,2);?></div>
<div style="color:red;"><?php echo $this->view->message; ?></div>
