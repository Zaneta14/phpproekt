<?php
            require_once('../model/database.php');
            require_once('../model/category.php');
            require_once('../model/category_db.php');
            require_once('../util/main.php');
            require_once('../model/city.php');
            require_once('../model/city_db.php');
            require_once('../model/user.php');
            require_once('../model/user_db.php');
?>

<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main class="nofloat">
    <h1>Мој профил</h1>
    <p><?php echo $user_name . ' (' . $email . ')'; ?></p>
    <p><?php echo $address; ?></p>
    <p><?php echo $telNumber; ?></p>
    <form action="." method="post">
        <input type="hidden" name="action" value="view_account_edit">
        <input type="submit" value="Edit Account">
    </form>
    
    <?php if (count($orders) > 0 ) : ?>
        <h2>Мои нарачки</h2>
        <ul>
            <?php foreach($orders as $order) :
                $order_id = $order['orderID'];
                $order_date = strtotime($order['orderDate']);
                $order_date = date('M j, Y', $order_date);
                $url = $app_path . 'account' .
                       '?action=view_order&order_id=' . $order_id;
                ?>
                <li>
                    <a href="<?php echo $url; ?>">Нарачка направена на <?php echo $order_date; ?>
                    <?php echo $order_id; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>
