<?php
class OrderItem {
    private $id, $order, $product, $quantity;

    public function __construct($order, $product, $quantity) {
        $this->order = $order;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($value) {
        $this->order = $value;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($value) {
        $this->product = $value;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($value) {
        $this->id = $value;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($value) {
        $this->orderDate = $value;
    }
}