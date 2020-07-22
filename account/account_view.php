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
        <input type="submit" value="Уреди">
    </form>
    
    <?php if (count($orders) > 0 ) : ?>
        <h2>Мои нарачки</h2>
        <ul>
            <?php foreach($orders as $order) :
                $order_id = $order->getID();
                $order_date = strtotime($order->getOrderDate());
                $order_date = date('M j, Y H:i:s', $order_date);
                $url = $app_name . 'account' .
                       '?action=view_order&order_id=' . $order_id;
                ?>
                <li>
                    <a href="<?php echo $url; ?>">Нарачка направена на <?php echo $order_date; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($products_to_ship) > 0 ) : ?>
        <h2>Нарачки за испорака</h2>
        <ul>
            <?php foreach($products_to_ship as $product_to_ship) :
                $product_name=$product_to_ship->getProduct()->getName();
                $order_item_id=$product_to_ship->getID();
                $url=$app_name.'account?action=view_product_to_ship&order_item_id='.$order_item_id;
                ?>
                <li>
                    <a href="<?php echo $url; ?>"><?php echo $product_name; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Мои огласи</h2>
    <h3><a href="?action=show_add_edit_form">Додај оглас</a></h3>
    <?php if (count($products) > 0 ) : ?>
        <ul>
            <?php foreach($products as $product) :
                $product_id = $product->getID();;
                $product_name=$product->getName();
                $url = $app_name . 'account' .
                       '?action=view_product&product_id=' . $product_id;
                ?>
                <li>
                    <a href="<?php echo $url; ?>"><?php echo $product_name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <h4>Нема огласи.</h4>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>
