<?php

require_once('../../util/main.php');
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

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {        
        $action = 'list_products';
    }
}

switch ($action) {
    case 'list_products':
        
        $category_id = filter_input(INPUT_GET, 'category_id', 
                FILTER_VALIDATE_INT);
        if (empty($category_id)) {
            $category_id = 1;
        }
        $current_category = CategoryDB::getCategory($category_id);
        $categories = CategoryDB::getCategories();
        // $products = ProductDB::getProductsByCategory($category_id);

        include('product_list.php');
        break;
        case 'view_product_admin':

            // $category_id = filter_input(INPUT_POST, 'category_id', 
            // FILTER_VALIDATE_INT);
            $product_id = filter_input(INPUT_GET, 'product_id',FILTER_VALIDATE_INT);
            $product = ProductDB::getProduct($product_id);
            $category_id = filter_input(INPUT_GET, 'category_id',FILTER_VALIDATE_INT);
            $category=CategoryDB::getCategory($category_id);
            $userID = $product->getUser()->getID();
            $user = UserDB::getUser($userID);
            include('product_view_admin.php');

        break;
        case 'delete_product':
            $category_id = filter_input(INPUT_POST, 'category_id', 
                    FILTER_VALIDATE_INT);
            $product_id = filter_input(INPUT_POST, 'product_id', 
                    FILTER_VALIDATE_INT);
            ProductDB::deleteProduct($product_id);

            header("Location: .?category_id=$category_id");
            break;

        }
?>