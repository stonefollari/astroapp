<?php 
namespace AstroApp\Web\Protected\Private\Entities;

class User {
    private int $userId;
    private String $name;
    private String $emailAddress;
    private String $password;

    function __construct($_name) {
        $this->name = $_name;
    }

    //====Getters=====
    public getName() {
        return $this->$name;
    }

    //===Setters=======
    public setName($_emailAddress) {
        this $this->emailAddress = $_emailAddress;
    }
}
