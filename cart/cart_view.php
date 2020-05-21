<?php include '../view/header.php'; ?>


    <h1>
    Вашата кошничка
    </h1>

    <?php if (cartProductCount() == 0) : ?>
        <p>Немате производи во кошничката</p>
    <?php else: ?>

        <form action="." method="post">
            
            <table >
            <tr >
                <th >Item</th>
                <th >Price</th>
                <th >Total</th>
                <th >&nbsp;</th>
            </tr>
            <?php foreach ($cart as $product_id => $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td >
                    <?php echo sprintf('$%.2f', $item['price']); ?>
                </td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="remove">
                    <input type="hidden" name="product_id"
                           value="<?php echo $product['productID']; ?>">
                    <input type="submit" value="Remove">
                </form></td>
            </tr>
            <?php endforeach; ?>
            <tr >
                <td colspan="3"  ><b>Subtotal</b></td>
                <td >
                    <?php echo sprintf('$%.2f', cartSubtotal()); ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="right">
                    <input type="submit" value="Update Cart">
                </td>
            </tr>
            </table>
        </form>
        <?php endif; ?>

    <p>Return to: <a href="../">Home</a></p>

    
    <?php if (isset($_SESSION['last_category_id'])) :
            $category_url = '../catalog' .
                '?category_id=' . $_SESSION['last_category_id'];
        ?>
        <p>Return to: <a href="<?php echo $category_url; ?>">
            <?php echo $_SESSION['last_category_name']; ?></a></p>
    <?php endif; ?>

    
    <?php if (cartProductCount() > 0) : ?>
        <p>
            Proceed to: <a href="../checkout">Checkout</a>
        </p>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>