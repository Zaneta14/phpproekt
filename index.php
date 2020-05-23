<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<?php
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

$product_id = filter_input(INPUT_GET,'product_id',FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);

if ($category_id !== null) {
    $action = 'categories_filter';
}elseif($product_id!==null){
    $action = 'product';
}elseif($user_id!==null){
    $action = 'user_filter';
}
else {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {       
            $action = 'weekly_products';
    }
}

switch ($action) {
    case 'weekly_products':
        $ids = array(1,2,5);
        $products = array();
        foreach($ids as $id){
            $product = ProductDB::getProduct($id);
            $products[] = $product;
        }
        
        include('home.php');
        break;
    case 'cities_filter':
        $city_id=filter_input(INPUT_POST, 'selectedCity');
        $city=CityDB::getCity($city_id);
        $city_name=$city->getName();
        $products=array();
        $products=ProductDB::getProductsByCity($city_id);
        include('home.php');
        break;
    case 'categories_filter':
        $category=CategoryDB::getCategory($category_id);
        $category_name=$category->getName();
        $products=ProductDB::getProductsByCategory($category_id);
        include('home.php');
        break;
    /*case 'categories_cities_filter':
        $city_id=filter_input(INPUT_POST, 'selectedCity');
        $products=ProductDB::getProductsByCategoryAndCity($category_id, $city_id);
        include('home.php');
        break;*/
    case 'product' :
        $product = ProductDB::getProduct($product_id);
        $category_id = $product->getCategory()->getID();
        $product_code = $product->getCode();
        $product_name = $product->getName();
        $description = $product->getDescription();
        $price = $product->getPrice();
        $finish_date = substr($product->getFinishDate(),0,10);
        $start_date = substr($product->getStartDate(),0,10);
        $image_filename = $product_code . '.jpg';
        $image_path =  'images/' . $image_filename;
        $views = $product->getViews();
        $userID = $product->getUser()->getID();
        $user = UserDB::getUser($userID);
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $description_with_tags = add_tags($description);
        include('product_view.php');
        break;
    case 'user_filter':
        $user=UserDB::getUser($user_id);
        $user_name=$user->getFirstName().' '.$user->getLastName();
        $products=ProductDB::getProductsByUser($user_id);
        include('home.php');
        break;
    default:
        display_error("Unknown action: " . $action);
        break;
}


?>