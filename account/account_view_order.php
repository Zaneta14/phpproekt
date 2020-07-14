
<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main class="nofloat"> 
    <h1>Моја нарачка</h1>
    <p>Направена на: <?php echo $order_date; ?></p>

    <table id="cart">
        <tr id="cart_header">
            <th >Производ</th>
            <th >Цена</th>
            <th >Цена на достава</th>
            <th >Ден на достава</th>
            <th >Вкупно</th>
        </tr>
    <?php
        $subtotal = 0;
        foreach ($order_items as $item) :
            $item_id = $item->getID();
            $item_name=$item->getProduct()->getName();
            $item_price=$item->getProduct()->getPrice();
            $item_ship_amount=$item->getProduct()->getShipAmount();
            $item_ship_date=$item->getShipDate();

            $line_total = $item_price + $item_ship_amount;
            $subtotal += $line_total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item_name); ?></td>
                <td >
                    <?php echo $item_price. ' ден.'; ?>
                </td>
                <td >
                    <?php echo $item_ship_amount.' ден.'; ?>
                </td>
                <td >
                    <?php echo substr($item_ship_date, 0, 10); ?>
                </td>
                <td >
                    <?php echo $line_total . ' ден.'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr id="cart_footer">
            <td colspan="5" >Севкупно:</td>
            <td >
                <?php echo $subtotal.' ден.'; ?>
            </td>
        </tr>
</table>
</main>
<?php include '../view/footer.php'; ?>