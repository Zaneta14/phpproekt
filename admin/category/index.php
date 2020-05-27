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
require_once('../../util/main.php');
require_once('../../util/images.php');

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {        
        $action = 'list_categories';
    }
}

switch ($action) {
    case 'list_categories':
        $categories = CategoryDB::getCategories();

        include('category_list.php');
        break;
    case 'delete_category':
        $category_id = filter_input(INPUT_POST, 'category_id', 
                FILTER_VALIDATE_INT);

        CategoryDB::deleteCategory($category_id);
        
        header("Location: .");
        break;
    case 'add_category':
        $name = filter_input(INPUT_POST, 'name');

       
        if (empty($name)) {
            display_error('Мора да внесете име за категоријата.
                           Обидете се повторно.');
        } else {
            $category=new Category($name);
            $category->setID($category_id);
            $category_id = CategoryDB::addCategory($category);
        }

        header("Location: .");
        break;
    case 'update_category':
        $category_id = filter_input(INPUT_POST, 'category_id', 
                FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');

       
        if (empty($name)) {
            display_error('Мора да внесете име за категоријата.
            Обидете се повторно.');
        } else {
            $category=new Category($name);
            $category->setID($category_id);
            CategoryDB::updateCategory($category);
        }

        header("Location: .");
        break;
}

?>