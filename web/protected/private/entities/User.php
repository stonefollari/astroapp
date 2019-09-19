<?php 
namespace AstroApp\Web\Protected\Private\Entities;

class User {
    private $userId;
    private $name;
    private $emailAddress;
    private $password;

    function __construct($_name) {
        $this->name = $_name;
    }

    //====Getters=====
    public getName() {
        return $this->$name;
    }

    //===Setters=======
    public setName($_emailAddress) {
        $this->emailAddress = $_emailAddress;
    }
}
