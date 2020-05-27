<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>

<main>
    <h1>Прегледај производ</h1>
    
    
    <?php include '../../product_view.php'; ?>

    
    <br>
    <div id="edit_and_delete_buttons">
     
        
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_product">
            <input type="hidden" name="product_id"
                   value="<?php echo $product->getID(); ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $product->getID(); ?>">
            <input type="submit" value="Delete Product">
        </form>
        
    </div>
    
</main>
<?php include '../../view/footer.php'; ?>