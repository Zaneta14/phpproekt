

<?php

require_once('../model/database.php');
require_once('../util/main.php');
require_once('../util/validation.php');


require_once('../model/category.php');
require_once('../model/category_db.php');

require_once('../model/city.php');
require_once('../model/city_db.php');
require_once('../model/cart.php');
require_once('../model/user.php');
require_once('../model/user_db.php');
require_once('../model/product.php');
require_once('../model/product_db.php');

include '../view/header.php';
include '../view/sidebar.php';
?>

<?php

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {        
        $action = 'view';
    }
}

switch ($action){
    case 'view' :
        $cart = getCartItems();
        break;
    case 'add' :
        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
        cartAddItem($product_id);
        $cart = getCartItems();
        break;
    case 'remove':
        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
        cartRemoveItem($product_id);
        $cart = getCartItems();
        break;
default :
    add_error("Unknown cart action: ".$action);
    break;
}

include ('cart_view.php');
include ('../view/footer.php');

?>