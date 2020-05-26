<?php
require_once('../util/secure_conn.php');
require_once('../model/database.php');

require_once('../model/user.php');
require_once('../model/user_db.php');
require_once('../model/product.php');
require_once('../model/product_db.php');
require_once('../model/order_db.php');
require_once('../model/order.php');
require_once('../model/orderitem.php');
require_once('../model/category.php');
require_once('../model/category_db.php');
require_once('../model/city_db.php');
require_once('../model/city.php');

require_once('../model/fields.php');
require_once('../model/validate.php');
require_once('../util/main.php');
require_once('../util/images.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {        
        $action = 'view_login';
        if (isset($_SESSION['user'])) {
            $action = 'view_account';
        }
    }
}

// Set up all possible fields to validate
$validate = new Validate();
$fields = $validate->getFields();

// for the Registration page and other pages
$fields->addField('email', '');
$fields->addField('password_1');
$fields->addField('password_2');
$fields->addField('first_name');
$fields->addField('last_name');
$fields->addField('city');
$fields->addField('tel_number');
$fields->addField('address');

// for the Login page
$fields->addField('password');

switch ($action) {
    case 'view_register':
        // Clear user data
        $email = '';
        $first_name = '';
        $last_name = '';
        $city1 = '';
        $telNumber='';
        $address= '';
        $email_message1='';

        include 'account_register.php';
        break;
    case 'register':
        // Store user data in local variables
        $email = filter_input(INPUT_POST, 'email');
        $password_1 = filter_input(INPUT_POST, 'password_1');
        $password_2 = filter_input(INPUT_POST, 'password_2');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $city_id = filter_input(INPUT_POST, 'city');
        $telNumber = filter_input(INPUT_POST, 'telNumber');
        $address = filter_input(INPUT_POST, 'address');

        // Validate user data       
        $validate->email('email', $email);
        $validate->text('password_1', $password_1, true, 6, 30);
        $validate->text('password_2', $password_2, true, 6, 30);        
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);
        $validate->text('tel_number', $telNumber);
        $validate->text('address', $address);

        // If validation errors, redisplay Register page and exit controller
        if ($fields->hasErrors()) {
            include 'account_register.php';
            break;
        }

        // If passwords don't match, redisplay Register page and exit controller
        if ($password_1 !== $password_2) {
            $password_message = 'Passwords do not match.';
            include 'account_register.php';
            break;
        }

        // Validate the data for the customer
        if (UserDB::is_valid_user_email($email)) {
            $email_message1 = 'The e-mail address ' . $email . ' is already in use.';
            include 'account_register.php';
            break;
        }
        
        $city_object=CityDB::getCity($city_id);

        // Add the customer data to the database
        $userObj=new User($city_object, $email, $password_1, $first_name, $last_name, $telNumber, $address);
        $user_id = UserDB::addUser($userObj);

        // Store user data in session
        $_SESSION['user'] = UserDB::getUser($user_id);
        
        // Redirect to the Checkout application if necessary
        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }        
        break;
    case 'view_login':
        // Clear login data
        $email = '';
        $password = '';
        $password_message = '';
        
        include 'account_login_register.php';
        break;
    case 'login':
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        
        // Validate user data
        $validate->email('email', $email);
        $validate->text('password', $password, true, 6, 30);        

        // If validation errors, redisplay Login page and exit controller
        if ($fields->hasErrors()) {
            include 'account_login_register.php';
            break;
        }
        
        // Check email and password in database
        if (UserDB::is_valid_user_login($email, $password)) {
            $_SESSION['user'] = UserDB::getUserByEmail($email);
        } else {
            $password_message = 'Login failed. Invalid email or password.';
            include 'account_login_register.php';
            break;
        }

        // If necessary, redirect to the Checkout app
        // Redirect to the Checkout application
        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }        
        break;
    case 'view_account':
        $user_name = $_SESSION['user']->getFirstName() . ' ' . $_SESSION['user']->getLastName();
        $email = $_SESSION['user']->getEmail();    
        $telNumber=$_SESSION['user']->getTelNumber();
        $address=$_SESSION['user']->getUserAddress();   
        $orders=OrderDB::getOrdersByUser($_SESSION['user']->getID());
        $products=ProductDB::getProductsByUser($_SESSION['user']->getID());
        $products_to_ship=OrderDB::getOrderItemsByUser($_SESSION['user']->getID());
        if (!isset($orders)) {
            $orders = array();
        }   
        if (!isset($products)) {
            $products = array();
        }  
        if (!isset($products_to_ship)) {
            $products_to_ship = array();
        }     
        $product_description='';
        include 'account_view.php';
        break;
    case 'view_order':
        $order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
        $order = OrderDB::getOrder($order_id);
        $order_date = strtotime($order->getOrderDate());

        $order_date = date('M j, Y', $order_date);
        //$ship_date = date('M j, Y', $ship_date);
        $order_items = OrderDB::getOrderItems($order_id);
        
        include 'account_view_order.php';
        break;
    case 'view_product_to_ship':
        $order_item_id=filter_input(INPUT_GET, 'order_item_id', FILTER_VALIDATE_INT);
        $order_item=OrderDB::getOrderItem($order_item_id);
        $product_id=$order_item->getProduct()->getID();
        $product=ProductDB::getProduct($product_id);
        $order_id=$order_item->getOrder()->getID();
        $order=OrderDB::getOrder($order_id);
        $user_id=$order->getUser()->getID();
        $user=UserDB::getUser($user_id);
        include 'view_product_to_ship.php';
    break;
    case 'view_product':
        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
        $product=ProductDB::getProduct($product_id);
        $category_id = $product->getCategory()->getID();
        $category_name = $product->getCategory()->getName();
        $product_code = $product->getCode();
        $product_description = $product->getDescription();
        $image_filename = $product_code . '.jpg';
        $image_path =  '../images/' . $image_filename;
        $description_with_tags = add_tags($product_description);

        include 'account_view_product.php';
        break;
    case 'show_add_edit_form':
        $product_id=filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $category_id=filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $product=ProductDB::getProduct($product_id);
        $product_name=$product->getName();
        $product_code=$product->getCode();
        $product_price=$product->getPrice();
        $product_ship_amount=$product->getShipAmount();
        $product_ship_days=$product->getShipDays();
        $product_description=$product->getDescription();
        $error_message='';
        include 'product_add_edit.php';
        break;
    case 'add_product':
        $category_id = filter_input(INPUT_POST, 'category_id', 
                 FILTER_VALIDATE_INT);
        $category_name=CategoryDB::getCategory($category_id)->getName();
        $product_code = filter_input(INPUT_POST, 'code');
        $product_name = filter_input(INPUT_POST, 'name');
        $product_description = filter_input(INPUT_POST, 'description');
        $product_price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $product_ship_days = filter_input(INPUT_POST, 'days', FILTER_VALIDATE_INT);
        $product_ship_amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT);
        $product_start_date=date("Y-m-d H:i:s");    
        $product_finish_date=date("Y-m-d H:i:s");
        $product_views=0;
        $description_with_tags = add_tags($product_description);

        // Validate inputs
        if (empty($product_code) || empty($product_name) || empty($product_description) || 
            empty($product_price) || empty($product_ship_days) || empty($product_ship_amount) 
            || $product_price === false || $product_ship_days === false || $product_ship_amount === false) {
                $error_message = 'Невалидни податоци. Провери ги сите полиња и пробај повторно.';
                include('product_add_edit.php');
        } else {
            $category=CategoryDB::getCategory($category_id);
            $user_id=$_SESSION['user']->getID();
            $user=UserDB::getUser($user_id);
            $product=new Product($category, $user, $product_views, $product_name, $product_description, $product_code, 
            $product_price, $product_start_date, $product_finish_date, $product_ship_amount, $product_ship_days);
            $product_id = ProductDB::addProduct($product);
            $product = ProductDB::getProduct($product_id);
            include('account_view_product.php');
        }
        break;    
    case 'update_product':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $product_code = filter_input(INPUT_POST, 'code');
        $product_name = filter_input(INPUT_POST, 'name');
        $product_description = filter_input(INPUT_POST, 'description');
        $product_price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $product_ship_days = filter_input(INPUT_POST, 'days', FILTER_VALIDATE_INT);
        $product_ship_amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT);
        $description_with_tags = add_tags($product_description);
    
        // Validate inputs
        if (empty($product_code) || empty($product_name) || empty($product_description) || 
            empty($product_price) || empty($product_ship_days) || empty($product_ship_amount) 
            || $product_price === false || $product_ship_days === false || $product_ship_amount === false) {
                $error_message = 'Невалидни податоци. Провери ги сите полиња и пробај повторно.';
                include('product_add_edit.php');
        } else {
            $category=CategoryDB::getCategory($category_id);
            $category_name=$category->getName();
            $user_id=$_SESSION['user']->getID();
            $user=UserDB::getUser($user_id);

            $old_product=ProductDB::getProduct($product_id);
            $product_views=$old_product->getViews();
            $product_start_date=$old_product->getStartDate();
            $product_finish_date=$old_product->getFinishDate();

            $product_obj=new Product($category, $user, $product_views, $product_name, $product_description, $product_code, 
            $product_price, $product_start_date, $product_finish_date, $product_ship_amount, $product_ship_days);
            $product_obj->setID($product_id);
            ProductDB::updateProduct($product_obj);
            $product = ProductDB::getProduct($product_id);
            include('account_view_product.php');
            }
        break;
    case 'view_account_edit':
        $email = $_SESSION['user']->getEmail();
        $first_name = $_SESSION['user']->getFirstName();
        $last_name = $_SESSION['user']->getLastname();
        $address = $_SESSION['user']->getUserAddress();
        $tel_number = $_SESSION['user']->getTelNumber();
        $city_id1=$_SESSION['user']->getCity()->getID();
        $city_name=$_SESSION['user']->getCity()->getName();

        $password_message = '';
        $password_message1 = '';
        $email_message='';

        include 'account_edit.php';
        break;
    case 'update_account':
        // Get the customer data
        $user_id = $_SESSION['user']->getID();
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $password_1 = filter_input(INPUT_POST, 'password_1');
        $password_2 = filter_input(INPUT_POST, 'password_2');
        $city_id = filter_input(INPUT_POST, 'city');
        $tel_number = filter_input(INPUT_POST, 'tel_number');
        $address = filter_input(INPUT_POST, 'address');
        $password_message = '';

        // Get the old data for the customer
        $old_user = UserDB::getUser($user_id);
        $old_email=$old_user->getEmail();
        $old_password=$old_user->getPassword();

        // Validate user data
        $validate->email('email', $email);
        $validate->text('password_1', $password_1, false, 6, 30);
        $validate->text('password_2', $password_2, false, 6, 30);               
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);       
        $validate->text('tel_number', $tel_number);        
        $validate->text('address', $address);        
        
        // Check email change and display message if necessary
        if ($email != $old_email) {
            $email_message = 'You can\'t change the email address for an account.';
            $email=$old_email;
                include 'account_edit.php';
                break;
        }

        // If validation errors, redisplay Login page and exit controller
        if ($fields->hasErrors()) {
            include 'account_edit.php';
            break;
        }

        // Only validate the passwords if they are NOT empty
        if (!empty($password_1) && !empty($password_2)) {            
            if ($password_1 !== $password_2) {
                $password_message = 'Passwords do not match.';
                include 'account_edit.php';
                break;
            }
        }

        $city_object=CityDB::getCity($city_id);

        // Add the customer data to the database
        $user=new User($city_object, $email, $old_password, $first_name, $last_name, $tel_number, $address);
        UserDB::updateUser($user_id, $user, $password_1, $password_2);

        // Set the new customer data in the session
        $_SESSION['user'] = UserDB::getUser($user_id);

        redirect('.');
        break;
    case 'upload_image':
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $product = ProductDB::getProduct($product_id);
            $product_code = $product->getCode();
        
            $category_id = $product->getCategory()->getID();
            $category_name=$product->getCategory()->getName();
            $product_description = $product->getDescription();
            $image_filename = $product_code . '.jpg';
            $image_path =  '../images/' . $image_filename;
            $description_with_tags = add_tags($product_description);
            $image_dir = $doc_root . $app_name . 'images/';
        
            if (isset($_FILES['file1'])) {
                $source = $_FILES['file1']['tmp_name'];
                $target = $image_dir . DIRECTORY_SEPARATOR . $image_filename;
        
                // save uploaded file with correct filename
                move_uploaded_file($source, $target);
        
                // add code that creates the medium and small versions of the image
                process_image($image_dir, $image_filename);
        
                // display product with new image
                include('account_view_product.php');
            }
        break;
    case 'delete_product':
        $product_id=filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        ProductDB::deleteProduct($product_id);

        $user_name = $_SESSION['user']->getFirstName() . ' ' . $_SESSION['user']->getLastName();
        $email = $_SESSION['user']->getEmail();    
        $telNumber=$_SESSION['user']->getTelNumber();
        $address=$_SESSION['user']->getUserAddress();   
        $orders=OrderDB::getOrdersByUser($_SESSION['user']->getID());
        $products=ProductDB::getProductsByUser($_SESSION['user']->getID());
        if (!isset($orders)) {
            $orders = array();
        }   
        if (!isset($products)) {
            $products = array();
        }      
        $product_description='';
        
        include 'account_view.php';
        break;

    case 'logout':
        unset($_SESSION['user']);
        redirect('..');
        break;
    default:
        display_error("Unknown account action: " . $action);
        break;
}
?>