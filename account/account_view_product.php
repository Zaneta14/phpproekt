<?php

require_once('../model/database.php');
include '../view/header.php'; 
include '../view/sidebar.php';

$product_code = $product->getCode();
$image_filename = $product_code . '.jpg';
$image_path =  '../images/' . $image_filename;
$description = $product->getDescription();
$description_with_tags = add_tags($description);

?>

<h1><?php echo htmlspecialchars($product->getName()); ?></h1>
<div id="left_column">
    <p><img src="<?php echo $image_path; ?>"  width="300" height="300" /></p>
   
</div>

<div id="right_column">

<form action="." method="post" id="edit_button_form" >
            <input type="hidden" name="action" value="show_add_edit_form">
            <input type="hidden" name="product_id"
                   value="<?php echo $product_id; ?>">
            <input type="hidden" name="category_id" 
                   value="<?php echo $category_id; ?>">
            <input type="submit" value="Уреди оглас">
        </form>

    <p><b>Категорија:</b> &nbsp; <?php echo $category_name; ?></p>

    <p><b>Цена:</b>
    <?php echo number_format($product->getPrice(), 2); ?> ден.</p>
    <p><b>Цена на достава:</b> &nbsp; <?php echo $product->getShipAmount(); ?> ден.</p>
    <p><b>Време на достава:</b> &nbsp; <?php echo $product->getShipDays(); ?> дена</p>
    
    <?php echo $description_with_tags; ?>

    <p><b>Објавено нa:</b> &nbsp; <?php echo $product->getStartDate(); ?></p>

    <p><b>Број на прегледи:</b> &nbsp; <?php echo $product->getViews(); ?></p>

    <p><b>Огласот трае до:</b> &nbsp; <?php echo $product->getFinishDate(); ?></p>

</div>

<h3>Коментари</h3>
    <?php if (count($comments) > 0 ) : ?>
            <?php foreach($comments as $comment) :
            $user_name=$comment->getUser()->getFirstName() . ' ' . $comment->getUser()->getLastName();
            $comment_string=$comment->getCommentString(); ?>

            <p><b><?php echo $user_name?>:</b> <?php echo $comment_string?>
            <form action='.' method="post" id="delete_comment_form">
                <input type="hidden" name="action" value="delete_comment" />
                <input type="hidden" name="commentid" value="<?php echo $comment->getID(); ?>" />
                <input type="hidden" name="productid" value="<?php echo $product_id; ?>" />
                <input type="submit" value="Избриши">
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Нема коментари.</p>
    <?php endif; ?>
<?php include '../view/footer.php'; ?>