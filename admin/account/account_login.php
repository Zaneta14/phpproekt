<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main class="nofloat">
    <h1>Најава на Администратор</h1>
    <form action="." method="post" id="login_form">
        <input type="hidden" name="action" value="login">
        <div id="left_columnL">
        
        <label>Email адреса:</label><br><br>
        <label>Лозинка:</label>
        </div>

        <div class="right_columnL">
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <?php echo $fields->getField('email')->getHTML(); ?><br><br>
        <input type="password" name="password" size="30">
        <?php echo $fields->getField('password')->getHTML(); ?><br><br>


        <input id="login_reg_button" type="submit" value="Најави се">
        

        <?php if (!empty($password_message)) : ?>         
        <span class="error">
            <?php echo htmlspecialchars($password_message); ?>
        </span><br>
        <?php endif; ?>
        </div>
    </form>
</main>
<?php include '../../view/footer.php'; ?>