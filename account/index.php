<?php
require_once('../util/secure_conn.php');
require_once('../model/database.php');

require_once('../model/user.php');
require_once('../model/user_db.php');
require_once('../model/product.php');
require_once('../model/product_db.php');
require_once('../model/order_db.php');
require_once('../model/order.php');
require_once('../model/category.php');
require_once('../model/category_db.php');
require_once('../model/city_db.php');
require_once('../model/city.php');

require_once('../model/fields.php');
require_once('../model/validate.php');
require_once('../util/main.php');


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
        if (!isset($orders)) {
            $orders = array();
        }   
        if (!isset($products)) {
            $products = array();
        }      
        include 'account_view.php';
        break;
    case 'view_order':
        $order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
        $order = OrderDB::getOrder($order_id);
        $order_date = strtotime($order->getOrderDate());
        $ship_date = strtotime($order->getShipDate());
        $order_date = date('M j, Y', $order_date);
        $ship_date = date('M j, Y', $ship_date);
        $order_items = get_order_items($order_id);
        
        include 'account_view_order.php';
        break;
    case 'view_account_edit':
        $email = $_SESSION['user']->getEmail();
        $first_name = $_SESSION['user']->getFirstName();
        $last_name = $_SESSION['user']->getLastname();
        $address = $_SESSION['user']->getUserAddress();
        $tel_number = $_SESSION['user']->getTelNumber();
        $city_id=$_SESSION['user']->getCity()->getID();
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

    case 'logout':
        unset($_SESSION['user']);
        redirect('..');
        break;
    default:
        display_error("Unknown account action: " . $action);
        break;
}
?>