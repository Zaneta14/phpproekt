

<?php

require_once('../model/database.php');

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
require_once('../model/order.php');
require_once('../model/order_db.php');
require_once('../model/orderitem.php');
require_once('../util/main.php');

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
    case 'order':
        $product_id=filter_input(INPUT_POST, 'product_id');
        $category_id = filter_input(INPUT_POST,'category_id');
        if(isset($_SESSION['user'])){
            $cart = getCartItems();
            $user = $_SESSION['user'];
            $orderDate = date('Y-m-d');
            $order = new Order($user,$orderDate);
            OrderDB::addOrder($order);
            foreach($cart as $item){
                $shipDays=$item['shipDays'];
                $shipDate=date('Y-m-d', strtotime($orderDate. ' + ' . $shipDays . ' days'));
                $orderItem = new OrderItem($order,$item,$shipDate);
                OrderDB::addOrderItem($orderItem);
            }
            clearCart();
            include('cart_order_complete.php');
            break;
        }else{
            header('Location: ' . $app_name . '/account?product_id=' . $product_id);
        break;
        }
    
default :
    add_error("Unknown cart action: ".$action);
    break;
}

include ('cart_view.php');
include ('../view/footer.php');

?>