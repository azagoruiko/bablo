<form name="login" method="post" action="index.php?action=login">
    <div>User name</div>
    <input type="text" name="name" />
    <div>Password</div>
    <input type="password" name="pass" />
    <input type="submit" value="Субмит" />
    <?php
    if (!empty($view->error)) {
        echo "<div>{$view->error}</div>";
    }
    ?>
</form>

