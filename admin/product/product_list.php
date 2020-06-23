<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main class="nofloat">
    <h1 class="top">Листа на сите производи</h1>
    <p>За да погледнете или избришете производ, одберете производ.</p>
    
    <?php foreach($categories as $category):?>
    <?php  $products = ProductDB::getProductsByCategory($category->getID());?>
        <h1>
        <?php echo htmlspecialchars($category->getName()); ?>
        </h1>
    <?php if (count($products) == 0) : ?>
        <p>Нема производи во оваа категорија</p>
    <?php else : ?>
       
            <?php foreach ($products as $product) : ?>
            <p>
                <a href="?action=view_product_admin&amp;product_id=<?php
                          echo $product->getID(); ?>&amp;category_id=<?php echo $product->getCategory()->getID()?>">
                    <?php echo htmlspecialchars($product->getName()); ?>
                </a>
            </p>
            <?php endforeach; ?>
    <?php endif; ?>
    <?php endforeach; ?>
</main>
<?php include '../../view/footer.php'; ?>