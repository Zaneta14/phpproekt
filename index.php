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

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
if ($category_id !== null) {
    $action = 'categories_filter';
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
        break;
    case 'cities_filter':
        $city_id=filter_input(INPUT_POST, 'selectedCity');
        $city=CityDB::getCity($city_id);
        $city_name=$city->getName();
        $products=array();
        $products=ProductDB::getProductsByCity($city_id);
        break;
    case 'categories_filter':
        $category=CategoryDB::getCategory($category_id);
        $category_name=$category->getName();
        $products=ProductDB::getProductsByCategory($category_id);
        break;
    default:
        display_error("Unknown action: " . $action);
        break;
}

include('home.php');
?>