<?php 
require_once('../../model/administrator.php');
require_once('../../model/administrator_db.php');
require_once('../../util/main.php');
require_once('../../util/secure_conn.php');
require_once('../../model/database.php');



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

$action = filter_input(INPUT_POST, 'action');
if (AdminDB::admin_count() == 0) {
    if ($action != 'create') {
        $action = 'view_account';
    }
} elseif (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'view_account';            
        }
    }
} elseif ($action == 'login') {
    $action = 'login';
} else {
    $action = 'view_login';
}


$validate = new Validate();
$fields = $validate->getFields();


$fields->addField('email', 'Must be valid email.');
$fields->addField('password_1');
$fields->addField('password_2');
$fields->addField('first_name');
$fields->addField('last_name');

$fields->addField('password');

switch ($action) {
    case 'view_login':
        
        $email = '';
        $password = '';
        $password_message = '';
        
        include 'account_login.php';
        break;
    case 'login':
        
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        
               
        $validate->email('email', $email);
        $validate->text('password', $password, true, 6, 30);        

        
        if ($fields->hasErrors()) {
            $password_message = 'Неуспешно логирање.Погрешен е-маил или лозинка.';
            include 'account_login.php';
            break;
        }

        if (AdminDB::is_valid_admin_login($email, $password)) {
            $_SESSION['admin'] = AdminDB::get_admin_by_email($email);
        } else {
            $password_message = 'Неуспешно логирање.Погрешен е-маил или лозинка.';
            include 'account_login.php';
            break;
        }
        redirect('.');
        break;
    case 'view_account':
        
        $admins = AdminDB::get_all_admins();

        $admin_name = $_SESSION['admin']->getFirstName() . ' ' . $_SESSION['admin']->getLastName();
        $admin_email = $_SESSION['admin']->getEmail(); 

       
        $email = '';
        $first_name = '';
        $last_name = '';
        if (!isset($email_message)) { 
            $email_message = '';             
        }
        if (!isset($password_message)) { 
            $password_message = '';             
        }
        include 'account_view.php';
        break;

        case 'create':
            
            $email = filter_input(INPUT_POST, 'email');
            $first_name = filter_input(INPUT_POST, 'first_name');
            $last_name = filter_input(INPUT_POST, 'last_name');
            $password_1 = filter_input(INPUT_POST, 'password_1');
            $password_2 = filter_input(INPUT_POST, 'password_2');
    
            $admins = AdminDB::get_all_admins();
            $email_message = '';             
            $password_message = '';             
    
            
            $validate->email('email', $email);
            $validate->text('first_name', $first_name);
            $validate->text('last_name', $last_name);        
            $validate->text('password_1', $password_1, true, 6, 30);
            $validate->text('password_2', $password_2, true, 6, 30);     
            
           
            if ($fields->hasErrors()) {
                include 'account_view.php';
                break;
            }
            
            if (AdminDB::is_valid_admin_email($email)) {
                $email_message = 'Веќе искористен е-маил.';
                include 'account_view.php';
                break;
            }
            
            if ($password_1 !== $password_2) {
                $password_message = 'Лозинките не се совпаѓаат.';
                include 'account_view.php';
                break;
            }
            $admin_id = AdminDB::add_admin($email, $first_name, $last_name,
                                 $password_1);

        
        if (!isset($_SESSION['admin'])) {
            $_SESSION['admin'] = AdminDB::get_admin($admin_id);
        }

        redirect('.');
        break;

        case 'view_edit':
            
            $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
            $admin = AdminDB::get_admin($admin_id);
            $first_name = $admin->getFirstName();
            $last_name = $admin->getLastName();
            $email = $admin->getEmail();
            $password_message = '';
    
            
            include 'account_edit.php';
            break;

            case 'update':
        $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, 'email');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $password_1 = filter_input(INPUT_POST, 'password_1');
        $password_2 = filter_input(INPUT_POST, 'password_2');
        
        
        $validate->email('email', $email);
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);        
        $validate->text('password_1', $password_1, false, 6, 30);
        $validate->text('password_2', $password_2, false, 6, 30);     
        
        
        if ($fields->hasErrors()) {
            include 'admin/account/account_edit.php';
            break;
        }
        
        if ($password_1 !== $password_2) {
            $password_message = 'Passwords do not match.';
            include 'admin/account/account_edit.php';
            break;
        }
        
        AdminDB::update_admin($admin_id, $email, $first_name, $last_name, 
                $password_1, $password_2);
       
        if ($admin_id == $_SESSION['admin']['adminID']) {
            $_SESSION['admin'] = get_admin($admin_id);
        }
        redirect($app_name . 'admin/account/.?action=view_account');
        break;
    
        case 'update':
            $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
            $email = filter_input(INPUT_POST, 'email');
            $first_name = filter_input(INPUT_POST, 'first_name');
            $last_name = filter_input(INPUT_POST, 'last_name');
            $password_1 = filter_input(INPUT_POST, 'password_1');
            $password_2 = filter_input(INPUT_POST, 'password_2');
            
            $validate->email('email', $email);
            $validate->text('first_name', $first_name);
            $validate->text('last_name', $last_name);        
            $validate->text('password_1', $password_1, false, 6, 30);
            $validate->text('password_2', $password_2, false, 6, 30);     
            
            
            if ($fields->hasErrors()) {
                include 'admin/account/account_edit.php';
                break;
            }
            
            if ($password_1 !== $password_2) {
                $password_message = 'Лозинките не одговараат.';
                include 'admin/account/account_edit.php';
                break;
            }
            
            AdminDB::update_admin($admin_id, $email, $first_name, $last_name, 
                    $password_1, $password_2);
           
            if ($admin_id == $_SESSION['admin']['adminID']) {
                $_SESSION['admin'] = get_admin($admin_id);
            }
            redirect($app_name . 'admin/account/.?action=view_account');
            break;
            case 'view_delete_confirm':
                $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
                if ($admin_id == $_SESSION['admin']['adminID']) {
                    display_error('Не можете да ја избришете вашата корисничка сметка.');
                }
                $admin = get_admin($admin_id);
                $first_name = $admin['firstName'];
                $last_name = $admin['lastName'];
                $email = $admin['emailAddress'];
                include 'account_delete.php';
                break;

                case 'delete':
                    $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
                    delete_admin($admin_id);
                    redirect($app_name . 'admin/account');
                    break;
                case 'logout':
                    unset($_SESSION['admin']);
                    redirect($app_name . 'admin');
                    break;
                default:
                    display_error('Unknown account action: ' . $action);
                    break;

                }
?>