<?php
class Comment {
    private $id;
    private $user, $product, $commentString;

    public function __construct($user, $product, $commentString) {
        $this->user = $user; 
        $this->product = $product;
        $this->commentString = $commentString;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($value) {
        $this->id = $value;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($value) {
        $this->user = $value;
    }
    public function getProduct() {
        return $this->product;
    }

    public function setProduct($value) {
        $this->product = $value;
    }
    public function getCommentString() {
        return $this->commentString;
    }

    public function setCommentString($value) {
        $this->commentString = $value;
    }
}
?>