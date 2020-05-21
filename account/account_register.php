<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<?php 
if (!isset($password_message)) { $password_message = ''; } 
?>
<main>
    <h1>Регистрација</h1>
    <form action="." method="post" id="register_form">
        <input type="hidden" name="action" value="register">

        <label>Email адреса:</label>
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <?php echo $fields->getField('email')->getHTML(); ?><br>

        <label>Лозинка:</label>
        <input type="password" name="password_1" size="30">
        <?php echo $fields->getField('password_1')->getHTML(); ?>
        <span class="error"><?php echo htmlspecialchars($password_message); ?></span><br>

        <label>Потврди лозинка:</label>
        <input type="password" name="password_2" size="30">
        <?php echo $fields->getField('password_2')->getHTML(); ?><br>

        <label>Име:</label>
        <input type="text" name="first_name"
               value="<?php echo htmlspecialchars($first_name); ?>" 
               size="30">
        <?php echo $fields->getField('first_name')->getHTML(); ?><br>

        <label>Презиме:</label>
        <input type="text" name="last_name"
               value="<?php echo htmlspecialchars($last_name); ?>"
               size="30">
        <?php echo $fields->getField('last_name')->getHTML(); ?><br>

        <label>Град:</label>
        <input type="text" name="city"
               value="<?php echo htmlspecialchars($city); ?>" 
               size="30">
        <?php echo $fields->getField('city')->getHTML(); ?><br>

        <label>Адреса на живеење:</label>
        <input type="text" name="address"
               value="<?php echo htmlspecialchars($address); ?>"
               size="30">
        <?php echo $fields->getField('address')->getHTML(); ?><br>

        <label>Телефонски број:</label>
        <input type="text" name="telNumber"
               value="<?php echo htmlspecialchars($telNumber); ?>"
               size="30">
        <?php echo $fields->getField('ship_line2')->getHTML(); ?><br>

        <input type="submit" value="Register">
    </form>
</main>
<?php include '../view/footer.php'; ?>