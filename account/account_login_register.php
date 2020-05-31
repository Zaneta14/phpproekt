<?php
            require_once('../model/database.php');
            require_once('../model/category.php');
            require_once('../model/category_db.php');
            require_once('../util/main.php');
            require_once('../model/city.php');
            require_once('../model/city_db.php');
?>

<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>

<main class="nofloat"> 
    <h1>Најавa</h1>
    
    <form action="." method="post" id="login_form">
        <input type="hidden" name="action" value="login">
        <?php if (isset($product_id)) : ?>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <?php endif; ?>
        <div id="left_columnL">
        <label>Email адреса:</label>
        <br><br>
        <label>Лозинка:</label>
        </div>

        <div id="right_columnL">
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <?php echo $fields->getField('email')->getHTML(); ?><br><br>
        <input type="password" name="password" size="30">
        <?php echo $fields->getField('password')->getHTML(); ?><br><br>
        <input id="login_reg_button" type="submit" value="Најави се">
        <?php if (!empty($password_message)) : ?>         
        <span class="error"><?php echo htmlspecialchars($password_message); ?></span>
        <?php endif; ?>
        </div>


     
    </form>
<br><br>
    <h1>Регистрација</h1>
    <form action="." method="post">
        <input type="hidden" name="action" value="view_register">
        <?php if (isset($product_id)) : ?>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <?php endif; ?>
        <input  id="login_reg_button" type="submit" value="Регистрирај се">
    </form>
</main>
<?php include '../view/footer.php'; ?>
