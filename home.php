<?php include 'view/header.php';?>
<?php include 'view/sidebar.php'; ?>

<main class="nofloat">

<h3>
    <?php if (isset($category_name)) { ?>
        Производи од категорија <?php echo $category_name ?>
    <?php } elseif (isset($city_name)) { ?>
        Производи од град <?php echo $city_name ?>
    <?php } else { ?>
        Производи на неделата
    <?php } ?>
</h3> 

<table >
    <?php if ($products==null) { ?>
        <p>Нема производи во оваа категорија.</p>
    <?php } else { ?>
        <?php foreach ($products as $product) :
            
            $price = $product->getPrice();
            $description = $product->getDescription();
        ?>
            <tr>
                <td  >
                    <img src="images/<?php echo htmlspecialchars($product->getCode()); ?>.jpg"
                        alt="&nbsp;" width="400" height="400">
                </td>
                <td>
                    <h4>
                        <a href="products?product_id=<?php echo
                            $product->getID(); ?>">
                            <?php echo htmlspecialchars($product->getName()); ?>
                        </a>
                    </h4>
                    <p>
                        <b>Цена:</b>
                        <?php echo number_format($price, 2); ?> ден.
                    </p>
                    <p>
                        <!--<?php echo $first_paragraph; ?>-->
                        <?php echo htmlspecialchars($description); ?>
                    </p>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php } ?>

<?php include 'view/footer.php';?>