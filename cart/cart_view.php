
    <h1>
    Вашата кошничка
    </h1>

    <?php if (cartProductCount() == 0) : ?>
        <p>Немате производи во кошничката</p>
    <?php else: ?>

        <form action="." method="get">
            
            <table >
            <tr >
                <th >Производ</th>
                <th >Цена</th>
                <th> Цена на испорака</th>
                
                <th >&nbsp;</th>
            </tr>
            <?php foreach ($cart as $product_id => $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td >
                    <?php echo sprintf('%.2f ден.', $item['price']); ?>
                </td>
                <td>
                <?php echo sprintf('%.2f ден.', $item['shipAmount']); ?>
                </td>
                <td><form action="." method="get">
                    <input type="hidden" name="action"
                           value="remove">
                    <input type="hidden" name="product_id"
                           value="<?php echo $item['id'] ?>">
                    <input type="submit" value="Отстрани">
                </form></td>
            </tr>
            <?php endforeach; ?>
            <tr >
                <td colspan="3"  ><b>Вкупно</b></td>
                <td >
                    <?php echo sprintf('%.2f ден.', cartSubtotal()); ?>
                </td>
            </tr>
        
            </table>
        </form>
         
            <form action="." method="get">
                    <input type="hidden" name="action"
                           value="order">
                    <input type="hidden" name="order_id"
                           value="null">
                    <input type="hidden" name="product_id"
                           value="null">
                    <input type="submit" value="Нарачај">
                </form>
   
        <?php endif; ?>

    <p>Врати се на  <a href="../">Почетна</a></p>

    
    <?php if (isset($_SESSION['last_category_id'])) :
            $category_url = '../' .
                '?category_id=' . $_SESSION['last_category_id'];
        ?>
        <p>Врати се на  <a href="<?php echo $category_url; ?>">
            <?php echo $_SESSION['last_category_name']; ?></a></p>
    <?php endif; ?>

    
   
</main>
