<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>

<main class="nofloat">
    <h1>Прегледај производ</h1>
    
<?php
    require_once('../../util/secure_conn.php');
    require_once('../../model/database.php');

    require_once('../../model/administrator.php');
    require_once('../../model/administrator_db.php');

    require_once('../../model/user.php');
    require_once('../../model/user_db.php');
    require_once('../../model/product.php');
    require_once('../../model/product_db.php');
    require_once('../../model/order_db.php');
    require_once('../../model/order.php');
    require_once('../../model/orderitem.php');
    require_once('../../model/category.php');
    require_once('../../model/category_db.php');
    require_once('../../model/city_db.php');
    require_once('../../model/city.php');

    require_once('../../model/fields.php');
    require_once('../../model/validate.php');

    require_once('../../util/images.php');
    require_once('../../util/main.php');

    $product_code = $product->getCode();
    $image_filename = $product_code . '.jpg';
    $image_path =  '../../images/' . $image_filename;
    $description = $product->getDescription();
    $description_with_tags = add_tags($description);
?>

<h1><?php echo htmlspecialchars($product->getName()); ?></h1>
<div id="left_column">
    <p><img src="<?php echo $image_path; ?>"  width="300" height="300" /></p>
</div>

<div id="right_column">
    <p><b>Категорија: </b><?php echo $category->getName(); ?></p>

    <p><b>Цена:</b>
        <?php echo number_format($product->getPrice(), 2); ?> ден.</p>

    
    <?php echo $description_with_tags; ?>
    <p><b>Објавено нa:</b> &nbsp; <?php echo substr($product->getStartDate(), 0, 10); ?></p>

    <p><b>Број на прегледи:</b> &nbsp; <?php echo $product->getViews(); ?></p>

    <p><b>Огласот трае до:</b> &nbsp; <?php echo substr($product->getFinishDate(), 0, 10); ?></p>

    <p><b>Објавено од: </b>
    <a href="<?php echo $app_name?>?user_id=<?php echo $userID ?>"> &nbsp; <?php echo $user->getFirstName(); ?> &nbsp; <?php echo $user->getLastName(); ?> </a></p>

    <br>
    <div id="edit_and_delete_buttons">
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_product">
            <input type="hidden" name="product_id"
                   value="<?php echo $product->getID(); ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $product->getID(); ?>">
            <input type="submit" value="Избриши Производ">
        </form>
    </div>
</div>
<a href="../product">Назад</a>
</main>

<?php include '../../view/footer.php'; ?>