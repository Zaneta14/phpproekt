<?php
class Order {
    private $id, $user, $orderDate;
    
    public function __construct($user, $orderDate) {
        $this->user = $user;
        $this->orderDate = $orderDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($value) {
        $this->user = $value;
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
}