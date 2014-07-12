<form action="index.php?action=addIncome" method="post" name="newUser">
    <div>Amount:</div><input type="text" name="amount" />
    <div>Currency:</div><select name="currency_id">
        <?php
        foreach ($this->view->currencies as $c) {
            echo "<option value=\"{$c['id']}\">{$c['name']}</option>";
        }
        ?>
    </select>
    <div>Date:</div><input type="date" name="date" />
    <div>Source:</div><select multiple="true" name="source_id">
        <option value="1">Job 1</option>
        <option value="2">Job 2</option>
        <option value="3">Job 2</option>
    </select>
    <input type="submit" value="Субмит" />
    <?php if (!empty($view->error)) {
        echo "<div>{$view->error}</div>";
    } ?>
</form>


