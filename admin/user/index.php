<?php


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
require_once('../../util/main.php');

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {        
        $action = 'list_users';
    }
}

switch ($action) {
    case 'list_users':
        $city_id = filter_input(INPUT_GET,'city_id',FILTER_VALIDATE_INT);
       
        if (empty($city_id)) {
            $city_id = 1;
        }

        $current_city = CityDB::getCity($city_id);
        $cities = CityDB::getCities();
        // $users = UserDB::getUsersByCity($city_id);

        include('user_list.php');
        break;
        case 'view_user':
            $user_id = filter_input(INPUT_GET,'user_id',FILTER_VALIDATE_INT);
            $city_id = filter_input(INPUT_GET,'city_id',FILTER_VALIDATE_INT);
            
            $user = UserDB::getUser($user_id);
            $user_name = $user->getFirstName()." ".$user->getLastName();
            $email = $user->getEmail();
            $address = $user->getUserAddress();
            $telNumber = $user->getTelNumber();
            include('user_view.php');

        break;
        case 'delete_user':
            $city_id = filter_input(INPUT_GET,'city_id',FILTER_VALIDATE_INT);
        
            $user_id = filter_input(INPUT_GET,'user_id',FILTER_VALIDATE_INT);
            UserDB::deleteUser($user_id);

            redirect($app_path . 'user/index.php');

            header("Location: .?city_id=$city_id");
            break;

        }
?>