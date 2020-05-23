
<?php

include 'view/header.php'; 
include 'view/sidebar.php';

require_once('util/main.php');
require_once('model/database.php');

require_once('model/product.php');
require_once('model/product_db.php');
require_once('model/category.php');
require_once('model/category_db.php');
require_once('model/user.php');
require_once('model/user_db.php');
require_once('model/city.php');
require_once('model/city_db.php');
?>


<h1><?php echo htmlspecialchars($product_name); ?></h1>
<div id="left_column">
    <p><img src="<?php echo $image_path; ?>"  width="300" height="300" /></p>
   
</div>

<div id="right_column">
    <p><b>Цена:</b>
        <?php echo number_format($price, 2); ?> ден.</p>

        <form action="<?php echo $app_path . 'cart' ?>" method="get" 
          id="add_to_cart_form">
        <input type="hidden" name="action" value="add" />
        <input type="hidden" name="product_id"
               value="<?php echo $product_id; ?>" />
       
        <input type="submit" value="Стави во кошничка" />
    </form>
    
    <?php echo $description_with_tags; ?>
    <p><b>Објавено на  :</b> &nbsp; <?php echo $start_date; ?></p>

    <p><b>Број на прегледи :</b> &nbsp; <?php echo $views; ?></p>

    <p><b>Огласот трае до :</b> &nbsp; <?php echo $finish_date; ?></p>

    <p><b>Објавено од : </b>
    <a href="<?php echo $app_name?>?user_id=<?php echo $userID ?>"> &nbsp; <?php echo $firstName; ?> &nbsp; <?php echo $lastName; ?> </a></p>
   
    

    
</div>


<?php include 'view/footer.php'; ?>