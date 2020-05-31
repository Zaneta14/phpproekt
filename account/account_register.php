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
<?php 
if (!isset($password_message)) { $password_message = ''; } 
?>
<main class="nofloat">
    <h1>Регистрација</h1>
    <form action="." method="post" id="register_form">
        <input type="hidden" name="action" value="register">
        <?php if (isset($product_id)) : ?>
        <h2><?php echo $product_id; ?></h2>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <?php endif; ?>

        <label>Email адреса:</label>
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <?php echo $fields->getField('email')->getHTML(); ?><br>
        <span class="error"><?php echo htmlspecialchars($email_message1); ?></span><br>

        <label>Лозинка:</label>
        <input type="password" name="password_1" size="30">
        <?php echo $fields->getField('password_1')->getHTML(); ?>
        <span class="error"><?php echo htmlspecialchars($password_message); ?></span><br>

        <label>Потврди лозинка:</label>
        <input type="password" name="password_2" size="30">
        <?php echo $fields->getField('password_2')->getHTML(); ?><br>

        <label>Име:</label>
        <input type="text" name="first_name"
               value="<?php echo htmlspecialchars($first_name); ?>" 
               size="30">
        <?php echo $fields->getField('first_name')->getHTML(); ?><br>

        <label>Презиме:</label>
        <input type="text" name="last_name"
               value="<?php echo htmlspecialchars($last_name); ?>"
               size="30">
        <?php echo $fields->getField('last_name')->getHTML(); ?><br>

        <label>Град:</label>
            <select name="city">
                <option value="">Избери</option>
                <?php 
                    /*require_once('model/database.php');
                    require_once('model/city.php');
                    require_once('model/city_db.php');*/

                    $cities = CityDB::getCities();
                        foreach($cities as $city) :
                            $name = $city->getName();
                            $id = $city->getID();
                        ?>
                            <option value="<?php echo $id ?>">
                            <?php echo htmlspecialchars($name)?>
                            </option>
                        <?php endforeach; ?>
            </select>
            <br/>

        <label>Адреса на живеење:</label>
        <input type="text" name="address"
               value="<?php echo htmlspecialchars($address); ?>"
               size="30">
        <?php echo $fields->getField('address')->getHTML(); ?><br>

        <label>Телефонски број:</label>
        <input type="text" name="telNumber"
               value="<?php echo htmlspecialchars($telNumber); ?>"
               size="30">
        <?php echo $fields->getField('tel_number')->getHTML(); ?><br>

        <input type="submit" value="Регистрирај се">
    </form>
</main>
<?php include '../view/footer.php'; ?>