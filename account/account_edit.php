<?php
            require_once('../model/database.php');
            require_once('../model/category.php');
            require_once('../model/category_db.php');
            require_once('../util/main.php');
            require_once('../model/city.php');
            require_once('../model/city_db.php');
?>

<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main class="nofloat">
    <h1>Уреди профил</h1>
    <div id="edit_account_form">
    <form action="." method="post">
        <input type="hidden" name="action" value="update_account">

        <label>Email адреса:</label>
        <input type="text" name="email" 
               value="<?php echo htmlspecialchars($email); ?>">&nbsp;&nbsp;
        <?php echo $fields->getField('email')->getHTML(); ?><br>
        <span class="error"><?php echo $email_message; ?></span><br>

        
        <label>Имe:</label>
        <input type="text" name="first_name" 
               value="<?php echo htmlspecialchars($first_name); ?>">
        <?php echo $fields->getField('first_name')->getHTML(); ?><br>
        
        <label>Презиме:</label>
        <input type="text" name="last_name" 
               value="<?php echo htmlspecialchars($last_name); ?>">
        <?php echo $fields->getField('last_name')->getHTML(); ?><br>

        <label>Нова лозинка:</label>
        <input type="password" name="password_1">&nbsp;&nbsp;
        <?php echo $fields->getField('password_1')->getHTML(); ?>
        <span class="error"><?php echo $password_message; ?></span><br>

        <label>Потврди лозинка:</label>
        <input type="password" name="password_2">
        <?php echo $fields->getField('password_2')->getHTML(); ?><br>

        <label>Град:</label>
            <select name="city">
                <?php 
                    $cities = CityDB::getCities();
                        foreach($cities as $city) :
                            $name = $city->getName();
                            $id = $city->getID();
                            //$selected = ($id == $city_id) ? true : false;
                        ?>
                            <option value="<?php echo $id ?>" <?php if (isset($city_id)) {
                                if ($city_id == $id) { ?>selected="true" <?php }; ?>
                            <?php } ?>>
                            <?php echo htmlspecialchars($name)?>
                            </option>
                        <?php endforeach; ?>
            </select>
        <br/>
        <label>Адреса на живеење:</label>
        <input type="text" name="address" 
               value="<?php echo htmlspecialchars($address); ?>">
        <?php echo $fields->getField('address')->getHTML(); ?><br>

        <label>Телефонски број:</label>
        <input type="text" name="tel_number" 
               value="<?php echo htmlspecialchars($tel_number); ?>">
        <?php echo $fields->getField('tel_number')->getHTML(); ?><br>

        <label>&nbsp;</label>
        <input type="submit" value="Зачувај"><br>
    </form>
    <form action="." method="post">
        <label>&nbsp;</label>
        <input type="submit" value="Откажи">
    </form>
    </div>
</main>
<?php include '../view/footer.php'; ?>