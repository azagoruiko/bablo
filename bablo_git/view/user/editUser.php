<form action="index.php?action=createUser" method="post" name="newUser">
    <div>Name:</div><input type="text" name="name" />
    <div>Pass:</div><input type="password" name="pass" />
    <div>Repeat password:</div><input type="password" name="re_pass" />
    <input type="submit" value="Субмит" />
    <?php if (!empty($view->error)) {
        echo "<div>{$view->error}</div>";
    } ?>
</form>


