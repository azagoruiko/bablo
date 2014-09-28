<div class="row">
    
    
    <div class="col-md-6">
        
        <form id="addIncome" action="index.php?ctrl=income&action=addIncome" method="post" name="newUser">
            <div class="input-group">
                <label for="amount">Amount:</label>
                <input required class="form-control"  type="text" name="amount" />
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input required type="email" class="form-control"  type="text" name="name" />
            </div>
            <div class="input-group">
                <label for="url">URL:</label>
                <input required type="url" class="form-control"  type="text" name="url" />
            </div>
            <div class="input-group">
                <div>Currency:</div><select class="form-control"  name="currency_id">
                    <?php
                    foreach ($this->view->currencies as $c) {
                        echo "<option value=\"{$c['id']}\">{$c['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-group has-error">
                <div>Date:</div>
                <input class="form-control" required type="date" name="date" />
            </div>
            <div class="input-group">
                <div>Source:</div><select required class="form-control"  multiple="true" name="source_id">
                    <option value="1">Job 1</option>
                    <option value="2">Job 2</option>
                    <option value="3">Job 2</option>
                </select>
            </div>
            <input class="form-control"  type="submit" value="Субмит" />
            <?php
            if (!empty($view->error)) {
                echo "<div>{$view->error}</div>";
            }
            ?>
        </form>
    </div>
    <div class="col-md-3">
        <div id="messages" class="text-danger border-danger"></div>
    </div>
</div>
<script src="js/main.js"></script>
