<?php
class OrderItem {
    private $id, $order, $product;

    public function __construct($order, $product) {
        $this->order = $order;
        $this->product = $product;
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
}