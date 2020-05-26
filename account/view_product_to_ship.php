<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>

<main class="nofloat"> 
    <h1>Нарачка за испорака</h1>
    <p><b>Производ: </b><?php echo $product->getName(); ?></p>
    <p><b>Порачано на: </b><?php echo substr($order->getOrderDate(), 0, 10); ?></p>
    <?php $full_name=$user->getFirstName().' '.$user->getLastName(); ?>
    <p><b>Порачано од: </b><?php echo $full_name; ?></p>
    <p><b>Адреса: </b><?php echo $user->getUserAddress(); ?></p>
    <p><b>Телефонски број: </b><?php echo $user->getTelNumber(); ?></p>
    <p><b>Датум на испорака: </b><?php echo substr($order_item->getShipDate(), 0, 10); ?></p>
<?php include '../view/footer.php'; ?>