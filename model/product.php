<?php
class Product {
    private $id, $category, $user, $name, $description, 
    $code, $price, $startDate, $finishDate, $shipAmount, $shipDays;
    private $views;

    public function __construct($category, $user, $views, $name,
    $description, $code, $price, $startDate, 
    $finishDate, $shipAmount, $shipDays) {
        $this->category = $category;
        $this->user = $user;
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->views = $views;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
        $this->shipAmount = $shipAmount;
        $this->shipDays = $shipDays;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($value) {
        $this->category = $value;
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

    public function getCode() {
        return $this->code;
    }

    public function setCode($value) {
        $this->code = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        $this->description = $value;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($value) {
        $this->startDate = $value;
    }

    public function getFinishDate() {
        return $this->finishDate;
    }

    public function setFinishDate($value) {
        $this->finishDate = $value;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($value) {
        $this->views = $value;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPriceFormatted() {
        $formatted_price = number_format($this->price, 2);
        return $formatted_price;
    }

    public function setPrice($value) {
        $this->price = $value;
    }

    public function getImageFilename() {
        $image_filename = $this->code . '.jpg';
        return $image_filename;
    }

    public function getImagePath() {
        $image_path = '../images/' . $this->getImageFilename();
        return $image_path;
    }

    public function getImageAltText() {
        $image_alt = 'Image: ' . $this->getImageFilename();
        return $image_alt;
    }

    public function getShipAmount() {
        return $this->shipAmount;
    }

    public function setShipAmount($value) {
        $this->shipAmount = $value;
    }

    public function getShipDays() {
        return $this->shipDays;
    }

    public function setShipDays($value) {
        $this->shipDays = $value;
    }
   
}