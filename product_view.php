<?php

include 'view/header.php'; 
include 'view/sidebar.php';

require_once('util/main.php');
require_once('model/database.php');

$product_code = $product->getCode();
$image_filename = $product_code . '.jpg';
$image_path =  'images/' . $image_filename;
$description = $product->getDescription();
$description_with_tags = add_tags($description);

?>


<h1><?php echo htmlspecialchars($product->getName()); ?></h1>
<div id="left_column">
    <p><img src="<?php echo $image_path; ?>"  width="300" height="300" /></p>
</div>

<div id="right_column">
    <p><b>Категорија: </b><?php echo $category->getName(); ?></p>

    <p><b>Цена:</b>
        <?php echo number_format($product->getPrice(), 2); ?> ден.</p>

        <form action="<?php echo $app_name . 'cart' ?>" method="get" 
          id="add_to_cart_form">
        <input type="hidden" name="action" value="add" />
        <input type="hidden" name="product_id"
               value="<?php echo $product_id; ?>" />
       
        <input type="submit" value="Стави во кошничка" />
    </form>
    
    <?php echo $description_with_tags; ?>
    <p><b>Објавено нa:</b> &nbsp; <?php echo substr($product->getStartDate(), 0, 10); ?></p>

    <p><b>Број на прегледи:</b> &nbsp; <?php echo $product->getViews(); ?></p>

    <p><b>Огласот трае до:</b> &nbsp; <?php echo substr($product->getFinishDate(), 0, 10); ?></p>

    <p><b>Објавено од: </b>
    <a href="<?php echo $app_name?>?user_id=<?php echo $userID ?>"> &nbsp; <?php echo $user->getFirstName(); ?> &nbsp; <?php echo $user->getLastName(); ?> </a></p>
</div>

    <h3>Коментари</h3>
        <?php if (count($comments) > 0 ) : ?>
                <?php foreach($comments as $comment) :
                    $user_name=$comment->getUser()->getFirstName() . ' ' . $comment->getUser()->getLastName();
                    $comment_string=$comment->getCommentString(); ?>

                    <p><b><?php echo $user_name?>:</b> <?php echo $comment_string?>

                    <?php if (isset($_SESSION['user'])) {
                        if ($comment->getUser() == $_SESSION['user']) { ?>
                            <form action='.' method="post" id="delete_comment_form">
                                <input type="hidden" name="action" value="delete_comment" />
                                <input type="hidden" name="commentid" value="<?php echo $comment->getID(); ?>" />
                                <input type="hidden" name="productid" value="<?php echo $product_id; ?>" />
                                <input type="submit" value="Избриши">
                            </form>
                        <?php } 
                    }?> 
                <?php endforeach; ?>
        <?php else : ?>
            <p>Нема коментари.</p>
        <?php endif; ?>

        <form action="." method="post" id="add_comment_form">
            <input type="hidden" name="action" value="post_comment" />
            <input type="hidden" name="productid" value="<?php echo $product_id; ?>" />
            <textarea name="comment_text" rows="3"
                    cols="55" placeholder="Додади коментар..."></textarea>
            <input type="submit" value="Коментирај">
        </form>

<?php include 'view/footer.php'; ?>