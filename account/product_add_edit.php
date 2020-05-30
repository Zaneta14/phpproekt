<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main class="nofloat">

    <?php
    if (isset($product_id)) {

        $heading_text = 'Уреди оглас';
    } else {
        $heading_text = 'Додади оглас';
    }
    ?>
    <h1><?php echo $heading_text; ?></h1>
    <form action="." method="post" id="add_product_form">
        <?php if (isset($product_id)) : ?>
            <input type="hidden" name="action" value="update_product">
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
        <?php else: ?>
            <input type="hidden" name="action" value="add_product">
        <?php endif; ?>
            <input type="hidden" name="category_id"
                   value="<?php echo $category_id; ?>">

        <p><?php echo $error_message ?></p>

        <label>Категорија:</label>
        <select name="category_id">
        <?php foreach ($categories as $category) : 
            if ($category->getID() == $category_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $category->getID(); ?>"<?php
                      echo $selected ?>>
                <?php echo htmlspecialchars($category->getName()); ?>
            </option>
        <?php endforeach; ?>
        </select>
        <br>

        <label>Име:</label>
        <input type="text" name="name" 
               value="<?php echo htmlspecialchars($product->getName()); ?>" 
               size="50">
        <br>

        <label>Код:</label>
        <input type="text" name="code"
               value="<?php echo htmlspecialchars($product->getCode()); ?>">
        <br>

        <label>Цена:</label>
        <input type="text" name="price"
               value="<?php echo htmlspecialchars($product->getPrice()); ?>">
        <br>

        <label>Цена на достава:</label>
        <input type="text" name="amount"
               value="<?php echo htmlspecialchars($product->getShipAmount()); ?>"> ден.
        <br>

        <label>Време на достава:</label>
        <input type="text" name="days"
               value="<?php echo htmlspecialchars($product->getShipDays()); ?>"> дена
        <br>

        <label>Опис:</label>
        <textarea name="description" rows="10"
                  cols="65"><?php echo $product->getDescription(); ?></textarea>
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Submit">
        
    </form>

    <?php if ($heading_text == 'Уреди оглас') : ?>
    <div id="image_manager">
        <h1>Слика:</h1>
        <form action="." method="post" enctype="multipart/form-data" id="upload_image_form">
            <input type="hidden" name="action" value="upload_image">
            <input type="file" name="file1"><br>
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="submit" value="Upload Image">
        </form>
</div>  
<?php endif; ?>

    <h2>How to work with the description</h2>
        <ul>
            <li>Use two returns to start a new paragraph.</li>
            <li>Use an asterisk to mark items in a bulleted list.</li>
            <li>Use one return between items in a bulleted list.</li>
            <li>Use standard HMTL tags for bold and italics.</li>
        </ul>

    <?php if ($heading_text == 'Уреди оглас') : ?>
    </br>
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_product">
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $category_id; ?>">
            <input type="submit" value="Избриши оглас">
        </form>
        <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>