<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>

<?php 

require_once('../../model/database.php');
require_once('../../model/category.php');
require_once('../../model/category_db.php');
require_once('../../model/administrator.php');
require_once('../../model/administrator_db.php');
require_once('../../util/main.php');
require_once('../../model/city.php');
require_once('../../model/city_db.php');
require_once('../../model/user.php');
require_once('../../model/user_db.php');


?>
<main class="nofloat">
    <h1>Профили на Администратори</h1>
    <?php if (isset($_SESSION['admin'])) : ?>
    <h2>Мој профил</h2>
    <p><?php echo $admin_name. ' (' . $admin_email . ')'; ?></p>
    <form action="." method="post">
        <input type="hidden" name="action" value="view_edit">
        <input type="hidden" name="admin_id" 
               value="<?php echo $_SESSION['admin']->getID(); ?>">
        <input type="submit" value="Промени">
    </form>
    <?php endif; ?>
    <br>
    <hr style="border-width: 1px 1px 0;
           border-style: solid;
           border-color: #e3e3e3; 
           
           margin-left: auto;
           margin-right: auto;">
    <?php if ( count($admins) > 1 ) : ?>
        <h2>Други Администратори</h2>
        <table>
        <?php foreach($admins as $admin):
            if ($admin->getID() != $_SESSION['admin']->getID()) : ?>
            <tr>
                <td><?php echo $admin->getFirstName() . ', ' .
                           $admin->getLastName(); ?>
                </td>
                <td>
                    <form action="." method="post" >
                        <input type="hidden" name="action"
                            value="view_edit">
                        <input type="hidden" name="admin_id"
                            value="<?php echo $admin->getID(); ?>">
                        <input type="submit" value="Промени">
                    </form>
                    <form action="." method="post" >
                        <input type="hidden" name="action"
                            value="view_delete_confirm">
                        <input type="hidden" name="admin_id"
                            value="<?php echo $admin->getID(); ?>">
                        <input type="submit" value="Избриши">
                    </form>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <div >
    <br>
    <hr style="border-width: 1px 1px 0;
           border-style: solid;
           border-color: #e3e3e3; 
           
           margin-left: auto;
           margin-right: auto;">
    <h2>Додади Администратор</h2>

   
    
    <form action="." method="post" >
    <div id = "left_column">
    <input type="hidden" name="action" value="create">
        <label>Email адреса:</label><br><br>

        <label>Име:</label><br><br>

        <label>Презиме:</label><br><br>

        <label>Лозинка:</label><br><br>

        <label>Потврди лозинка:</label><br><br>
    </div>

    <div id = "right_column">
    <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>">
        <span class="error"><?php echo $email_message; ?></span>
        <?php echo $fields->getField('email')->getHTML(); ?><br><br>

        <input type="text" name="first_name"
               value="<?php echo htmlspecialchars($first_name); ?>">
        <?php echo $fields->getField('first_name')->getHTML(); ?><br><br>

        <input type="text" name="last_name"
               value="<?php echo htmlspecialchars($last_name); ?>">
        <?php echo $fields->getField('last_name')->getHTML(); ?><br><br>

        <input type="password" name="password_1">
        <span><?php echo htmlspecialchars($password_message); ?></span>
        <?php echo $fields->getField('password_1')->getHTML(); ?><br><br>

        <input type="password" name="password_2">
        <?php echo $fields->getField('password_2')->getHTML(); ?><br><br>
        <label>&nbsp;</label>
        <input type="submit" value="Додади">
    
    </div>
    </form>
    </div>
</main>
<?php include '../../view/footer.php'; ?>