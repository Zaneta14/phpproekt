<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>

<main class="nofloat">
    <h1>Прегледај корисник</h1>
    <p><?php echo $user_name . ' (' . $email . ')'; ?></p>
    <p><?php echo $address; ?></p>
    <p><?php echo $telNumber; ?></p>
    <br>
    <div id="edit_and_delete_buttons">
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" name="user_id"
                   value="<?php echo $user->getID(); ?>">
            <input type="hidden" name="city_id"
                   value="<?php echo $user->getID(); ?>">
            <input type="submit" value="Избриши Корисник">
        </form>
    </div>
<a href="../user">Назад</a>
</main>
<?php include '../../view/footer.php'; ?>