<?php include "templates/include/heeader.php"; ?>

<form action="admin.php?action=login" method="post" class="admin_login">
    <input type="hidden" name="login" value="true" />
    <?php if (isset($results['errorMessage'])) { ?>
    <div class="error_message"><?php echo $results['errorMessage']?></div>
    <?php } ?>

            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Ваш логин" required />
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Ваш пароль" required />
    <input type="submit" name="login" value="Войти">
</form>
<?php include "templates/include/footer.php" ?>
