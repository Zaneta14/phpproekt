<?php

if (!isset($_SESSION['cart']) ) {
    $_SESSION['cart'] = array();
}

function cartAddItem($product_id) {
    $product = ProductDB::getProduct($product_id);
    $_SESSION['cart'][$product_id] = $product_id;
    
    $_SESSION['last_category_id'] = $product->getID();
    $_SESSION['last_category_name'] = $product->getCategory()->getName();
}

function cartRemoveItem($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function getCartItems() {
    $items = array();
    foreach ($_SESSION['cart'] as $product_id ) {
        
        $product = ProductDB::getProduct($product_id);
        $price = $product->getPrice();

        $items[$product_id]['id'] = $product->getID();
        $items[$product_id]['name'] = $product->getName();
        $items[$product_id]['description'] = $product->getDescription();
        $items[$product_id]['price'] = $price;
        $items[$product_id]['shipAmount'] = $product->getShipAmount();
        $items[$product_id]['shipDays'] = $product->getShipDays();
       
    }
    return $items;
}

function cartProductCount() {
    return count($_SESSION['cart']);
}

function cartSubtotal() {
    $subtotal = 0;
    $cart = getCartItems();
    foreach ($cart as $item) {
        $subtotal += $item['price'];
    }
    return $subtotal;
}

function clearCart() {
    $_SESSION['cart'] = array();
}

function setLastCategory($category_id, $category_name) {
    $_SESSION['last_category_id'] = $category_id;
    $_SESSION['last_category_name'] = $category_name;
}

function setLastProduct($product_id, $product_name) {
    $_SESSION['last_product_id'] = $product_id;
    $_SESSION['last_product_name'] = $product_name;
}

function cartGetItemWord() {
    if (cart_product_count() == 1) {
        $item_word =  'Производ';
    } else {
        $item_word =  'Производи';
    }
    return $item_word;
}
?>