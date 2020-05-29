<aside>
        <h3>Категории</h3>
    <ul>
        <!-- display links for all categories -->
        <?php
            /*require_once('model/database.php');
            require_once('model/category.php');
            require_once('model/category_db.php');*/
            //require_once('../util/main.php');
            
            $categories = CategoryDB::getCategories();
            foreach($categories as $category) :
                $name = $category->getName();
                $id = $category->getID();
                $url = $app_name.'?category_id=' . $id;
        ?>
        <li>
            <a href="<?php echo $url; ?>">
               <?php echo htmlspecialchars($name); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <h3>Градови</h3>
    <?php if (strpos($app_path, "account")) {
        $act='..';
    }
        else {
            $act='.';
        }
     ?>
    <form action="<?php echo $act ?>" method="post" id="select_city_form">
        <input type="hidden" name="action" value="cities_filter"/>
            <select name="selectedCity">
                <option value="">Сите</option>
                <?php 
                    /*require_once('model/database.php');
                    require_once('model/city.php');
                    require_once('model/city_db.php');*/

                    $cities = CityDB::getCities();
                        foreach($cities as $city) :
                            $name = $city->getName();
                            $id = $city->getID();
                        ?>
                            <option 
                            <?php if (isset($city_id)) {
                                if ($city_id == $id) { ?>selected="true" <?php }; ?>
                            <?php } ?>
                            value="<?php echo $id ?>">
                            <?php echo htmlspecialchars($name)?>
                            </option>
                        <?php endforeach; ?>
            </select>
        <input type="submit" value="Филтрирај"/>
    </form>
   
    
    <ul>
        
        <?php
      
        $account_url = $app_name. 'admin/account';
        //$logout_url = $account_url . '?action=logout';
        $logout_url = $app_name . 'admin/account?action=logout';
        if (isset($_SESSION['admin'])) :
        ?>
        <li>
            <a href="<?php echo $logout_url; ?>">Одјави се</a>
        <?php else: ?>
           
        <?php endif; ?>
        </li>
        <!-- <li>
            <a href="<?php echo $app_name; ?>">Почетна</a>
        </li> -->
        <li>
        <?php $admin_url = $app_name.'admin'; ?>
            <a href="<?php echo $admin_url; ?>">Админ Мени</a>
        </li>
        <li>
            <a href="<?php echo $account_url;?>">Профил</a>
        </li>

   
    </ul>
</aside>