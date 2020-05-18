<?php
class Order {
    private $id, $user, $shipAmount, $orderDate, $shipDate;

    public function __construct($user, $shipAmount, $orderDate, $shipDate) {
        $this->user = $user;
        $this->shipAmount = $shipAmount;
        $this->orderDate = $orderDate;
        $this->shipDate = $shipDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($value) {
        $this->user = $value;
    }

    public function getShipAmount() {
        return $this->shipAmount;
    }

    public function setShipAmount($value) {
        $this->shipAmount = $value;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($value) {
        $this->id = $value;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function setOrderDate($value) {
        $this->orderDate = $value;
    }
    
    public function getShipDate() {
        return $this->shipDate;
    }

    public function setShipDate($value) {
        $this->shipDate = $value;
    }
}