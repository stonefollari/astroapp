<?php
class User {
    private $userId;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $password;

    function __construct($_firstName, $_lastName, $_emailAddress, $_password) {
        $this->firstName = $_firstName;
	$this->lastName = $_lastName;
	$this->emailAddress = $_emailAddress;
	$this->password = $_password;
	$this->userId = hash('sha256', $this->emailAddress);
    }

    //====Getters=====
    public function  getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getEmailAddress(){
        return $this->emailAddress;
    }
    public function getUserID() {
        return $this->userId;
    }

    //===Setters=======
    public function setEmail($_emailAddress) {
        $this->emailAddress = $_emailAddress;
    }
    public function setPasswrod($_password) {
        $this->password = $_password;
    }
}
