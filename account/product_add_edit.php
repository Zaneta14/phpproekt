
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


<div id = "left_column" >
<label>Категорија:</label>

<br><br>

<label>Име:</label>

<br><br>

<label>Код:</label>
<br><br>

<label>Цена:</label>
<br><br>

<label>Траење на оглас: </label>
<br><br>

<label>Цена на достава:</label>
<br><br>

<label>Време на достава:</label>
<br><br>

<label>Опис:</label>
<br><br>




</div>
<div id = "right_column" >
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
        <br><br>

        <input type="text" name="name" 
               value="<?php echo htmlspecialchars($product->getName()); ?>" 
               size="50">
        <br><br>

        <input type="text" name="code"
               value="<?php echo htmlspecialchars($product->getCode()); ?>">
        <br><br>

        <input type="text" name="price"
               value="<?php echo htmlspecialchars($product->getPrice()); ?>">
        <br><br>

        <input type="text" name="finishDate"
               value=""><span style="font-size:9px">гггг-мм-дд (Празно поле означува + 30 дена на моменталниот датум)</span> 
               <br><br>

        <input type="text" name="amount"
               value="<?php echo htmlspecialchars($product->getShipAmount()); ?>"> ден.
        <br><br>

        <input type="text" name="days"
               value="<?php echo htmlspecialchars($product->getShipDays()); ?>"> дена
        <br><br>

        <textarea name="description" rows="10"
                  cols="65"><?php echo $product->getDescription(); ?></textarea>
        <br><br>

        <label>&nbsp;</label>
        <input type="submit" value="Зачувај">
        <br><br>

</div>
</form>

    <?php if ($heading_text == 'Уреди оглас') : ?>
    <div id="image_manager">
        <h1>Слика:</h1>
        <form action="." method="post" enctype="multipart/form-data" id="upload_image_form">
            <input type="hidden" name="action" value="upload_image">
            <input type="file" name="file1"><br>
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="submit" value="Постави слика">
        </form>
</div>  
<?php endif; ?>

    <h2>Работа со описот</h2>
        <ul>
            <li>За нов параграф, користи два пати enter.</li>
            <li>Користи ѕвезда (*) за елементи во листа.</li>
            <li>Помеѓу елементи во листа, користи enter еднаш.</li>
            <li>За bold и italics користи стандардни HTML тагови.</li>
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

  

