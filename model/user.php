<?php
class User {
    private $id, $city, $email, $password, $firstName, $lastName, $telNumber, $userAddress;

    public function __construct($city, $email, $password, $firstName, $lastName, $telNumber, $userAddress) {
        $this->city = $city;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->telNumber = $telNumber;
        $this->userAddress = $userAddress;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($value) {
        $this->city = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($value) {
        $this->id = $value;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($value) {
        $this->firstName = $value;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($value) {
        $this->lastName = $value;
    }

    public function getTelNumber() {
        return $this->telNumber;
    }

    public function setTelNumber($value) {
        $this->telNumber = $value;
    }

    public function getUserAddress() {
        return $this->userAddress;
    }

    public function setUserAddress($value) {
        $this->userAddress = $value;
    }
}