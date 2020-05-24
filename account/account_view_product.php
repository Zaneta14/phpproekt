<?php

require_once('../model/database.php');


include '../view/header.php'; 
include '../view/sidebar.php';

?>

<h1><?php echo htmlspecialchars($product_name); ?></h1>
<div id="left_column">
    <p><img src="<?php echo $image_path; ?>"  width="300" height="300" /></p>
   
</div>

<div id="right_column">

<form action="." method="post" id="edit_button_form" >
            <input type="hidden" name="action" value="show_add_edit_form">
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $category_id; ?>">
            <input type="submit" value="Уреди оглас">
        </form>

        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_product">
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $category_id; ?>">
            <input type="submit" value="Избиши оглас">
        </form>

    <p><b>Категорија:</b> &nbsp; <?php echo $category_name; ?></p>

    <p><b>Цена:</b>
        <?php echo number_format($product_price, 2); ?> ден.</p>
    <p><b>Цена на достава:</b> &nbsp; <?php echo $product_ship_amount; ?> ден.</p>
    <p><b>Време на достава:</b> &nbsp; <?php echo $product_ship_days; ?> дена</p>
    
    <?php echo $description_with_tags; ?>

    <p><b>Објавено нa:</b> &nbsp; <?php echo $product_start_date; ?></p>

    <p><b>Број на прегледи:</b> &nbsp; <?php echo $product_views; ?></p>

    <p><b>Огласот трае до:</b> &nbsp; <?php echo $product_finish_date; ?></p>

</div>
<?php include '../view/footer.php'; ?>