<?php 
namespace AstroApp\Web\Prot\Priv\Entities;

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
		
    }

    //====Getters=====
    public function getName() {
        return $this->$name;
    }

    //===Setters=======
    public function setName($_emailAddress) {
        $this->emailAddress = $_emailAddress;
    }
}
