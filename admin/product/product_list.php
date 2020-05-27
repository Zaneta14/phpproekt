<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main class="nofloat">
    <h1 class="top">Листа на сите производи</h1>
    <p>За да погледнете или избришете производ, одберете производ.</p>
    
    <?php if (count($products) == 0) : ?>
        <p>Нема производи во оваа категорија</p>
    <?php else : ?>
        <h1>
            <?php echo htmlspecialchars($current_category->getName()); ?>
        </h1>
            <?php foreach ($products as $product) : ?>
            <p>
                <a href="?action=view_product&amp;product_id=<?php
                          echo $product->getID(); ?>">
                    <?php echo htmlspecialchars($product->getName()); ?>
                </a>
            </p>
            <?php endforeach; ?>
    <?php endif; ?>
</main>
<?php include '../../view/footer.php'; ?>