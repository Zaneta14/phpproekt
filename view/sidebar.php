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
    <form action="." method="post" id="select_city_form">
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
    <h4 class="home_button"><a href="<?php echo $app_name ?>">Почетна</a></h4>
    <?php if (isset($category_id)) {
        $account_url=$app_name.'account';
    }
    else {
            $account_url = $app_path . 'account';
    }
    $logout_url = $account_url . '?action=logout';
            if (isset($_SESSION['user'])) :
            ?>
                <h4 class="home_button"><a href="<?php echo $account_url; ?>">My Account</a></h4>
                <h4 class="home_button"><a href="<?php echo $logout_url; ?>">Logout</a></h4>
            <?php else: ?>
                <h4 class="home_button"><a href="<?php echo $account_url; ?>">Најава</a></h4>
            <?php endif; ?>
</aside>
