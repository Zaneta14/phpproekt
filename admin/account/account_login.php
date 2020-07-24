<?php 
    include '../../view/header.php';
    include '../../view/sidebar_admin.php';
    require_once('../../model/database.php');
    require_once('../../model/category.php');
    require_once('../../model/category_db.php');
    require_once('../../util/main.php');
    require_once('../../model/city.php');
    require_once('../../model/city_db.php');
    require_once('../../model/user.php');
    require_once('../../model/user_db.php');
    require_once('../../model/administrator.php');
    require_once('../../model/administrator_db.php');
?>

<main class="nofloat">
    <h1>Најава на Администратор</h1>
    <form action="." method="post" id="login_form">
        <input type="hidden" name="action" value="login">
        <div id="left_column">
        
        <label>Email адреса:</label><br><br>

        <label>Лозинка:</label>
        </div>

        <div class="right_column">
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <?php echo $fields->getField('email')->getHTML(); ?><br><br>
        <input type="password" name="password" size="30">
        <?php echo $fields->getField('password')->getHTML(); ?><br><br>

        <input  type="submit" value="Најави се"><br><br>
        </div>

        <?php if (!empty($password_message)) : ?>         
        <span class="error">
            <?php echo htmlspecialchars($password_message); ?>
        </span><br>
        <?php endif; ?>
        
    </form>
</main>
<?php include '../../view/footer.php'; ?>