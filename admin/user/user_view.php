<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>

<main>
    <h1>Прегледај корисник</h1>
    
    
    <?php include '../../account/account_view.php'; ?>

    
    <br>
    <div id="edit_and_delete_buttons">
     
        
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" name="user_id"
                   value="<?php echo $user->getID(); ?>">
            <input type="hidden" name="city_id"
                   value="<?php echo $user->getID(); ?>">
            <input type="submit" value="Delete User">
        </form>
        
    </div>
    
</main>
<?php include '../../view/footer.php'; ?>