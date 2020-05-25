<?php
class OrderItem {
    private $id, $order, $product,$shipDate;

    public function __construct($order, $product,$shipDate) {
        $this->order = $order;
        $this->product = $product;
        $this->shipDate = $shipDate;
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
    public function getShipDate() {
        return $this->shipDate;
    }

    public function setShipDate($value) {
        $this->shipDate = $value;
    }
}