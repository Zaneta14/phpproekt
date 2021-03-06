<?php
include 'view/header.php';
include 'view/sidebar.php'; 

?>

<main class="nofloat">

<h3>
    <?php if (isset($category_name)) { ?>
        Производи од категорија <?php echo $category_name ?>
    <?php } elseif (isset($user_name)) { ?>
        Производи од корисник <?php echo $user_name ?>
    <?php } elseif ($city_id==null) { ?>
        Одберете град.
    <?php } elseif (isset($city_name)) { ?>
        Производи од град <?php echo $city_name ?>
    <?php } else { ?>
        Производи на неделата
    <?php } ?>
</h3> 

<table >
    <?php if ($products==null) { ?>
        <p>Не се пронајдени производи.</p>
    <?php } else { ?>
        <?php foreach ($products as $product) :
            
            $price = $product->getPrice();
            $description = $product->getDescription();
            $description_with_tags = add_tags($description);
        ?>
            <tr>
                <td>
                    <img src="images/<?php echo htmlspecialchars($product->getCode()); ?>.jpg"
                        alt="&nbsp;" width="400" height="400">
                </td>
                <td>
                    <h4>
                   
                    <a href="?product_id=<?php echo
                            $product->getID(); ?>">
                            <?php echo htmlspecialchars($product->getName()); ?>
                        </a>
                    </h4>
                    <p>
                        <b>Цена:</b>
                        <?php echo number_format($price, 2); ?> ден.
                    </p>
                    <p>
                        <?php echo $description_with_tags; ?>
                    </p>
                    <?php if(strtotime($product->getFinishDate()) > time()): ?>
                    <p><b>Огласот трае до:</b> &nbsp; <?php echo substr($product->getFinishDate(), 0, 10); ?></p>
                    <?php else: ?>
                    <p style="color:red"><b>Огласот не е активен</p>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php } ?>

<?php include 'view/footer.php'; ?>