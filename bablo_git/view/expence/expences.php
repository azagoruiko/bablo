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
    $usdAmount=0;
    
    foreach ($this->view->expences as $expence) {
        $usdAmount+=$expence->getUsdAmount();
        $curentUsdAmount=round($expence->getUsdAmount(),2);
        echo "<tr><td>{$expence->getId()}</td>"
        . "<td>{$expence->getDate()}</td>"
        . "<td>{$expence->getAmount()}</td>"
        . "<td>{$expence->getCurrency()}</td>"
        . "<td>\${$curentUsdAmount}</td>"
        . "</tr>";
    }
    
?>
</table>
<div>Total USD Amount: <?php echo round($usdAmount,2);?></div>
<div style="color:red;"><?php echo $this->view->message; ?></div>


