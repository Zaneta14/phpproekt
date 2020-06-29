<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<?php 

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
    <h1>Избриши профил</h1>
    <p>Дали сакате да го избришете профилот за 
       <?php echo htmlspecialchars($last_name) . ', ' . 
                  htmlspecialchars($first_name) .
                  ' (' . htmlspecialchars($email) . ')'; ?>?</p>
    <form action="." method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="admin_id"
               value="<?php echo $admin_id; ?>">
        <input type="submit" value="Избриши Профил">
    </form>
    <form action="." method="post">
        <input type="submit" value="Откажи">
    </form>
</main>
<?php include '../../view/footer.php'; ?>