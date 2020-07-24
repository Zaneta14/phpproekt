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
    <h1>Уреди профил</h1>
    <div id="edit_account_form">
    <form action="." method="post">
    <div id = "left_column">
    <input type="hidden" name="action" value="update">
        <input type="hidden" name="admin_id"
               value="<?php echo $admin_id; ?>">
        <label>Email адреса:</label><br><br>

        <label>Име:</label><br><br>

        <label>Презиме:</label><br><br>

        <label>Нова лозинка:</label><br><br>

        <label>Потврди лозинка:</label><br><br>
    </div>

    <div id = "right_column">
    
    <input type="text" name="email" 
               value="<?php echo htmlspecialchars($email); ?>">
        <?php echo $fields->getField('email')->getHTML(); ?><br><br>

        <input type="text" name="first_name" 
               value="<?php echo htmlspecialchars($first_name); ?>">
        <?php echo $fields->getField('first_name')->getHTML(); ?><br><br>

        <input type="text" name="last_name" 
               value="<?php echo htmlspecialchars($last_name); ?>">
        <?php echo $fields->getField('last_name')->getHTML(); ?><br><br>

        <input type="password" name="password_1">
        <span>Leave blank to leave unchanged</span>
        <?php echo $fields->getField('password_1')->getHTML(); ?><br><br>

        <input type="password" name="password_2">
        <?php echo $fields->getField('password_2')->getHTML(); ?><br><br>
        <label>&nbsp;</label>
        <input type="submit" value="Уреди">
        <span class="error">
            <?php echo htmlspecialchars($password_message); ?>
        </span>
    </div>
    </form>

    <form action="." method="post">
    <div id = "left_column">
        <label >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;        
        </label>
        <input type="submit" value="Откажи">
        </div>
    </form>
</div>
</main>
<?php include '../../view/footer.php'; ?>