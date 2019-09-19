<?php 
namespace AstroApp\Web\Protected\Private\Entities;
    
class Location {
    private $locationId;
    private $country;
    private $state;
    private $city;

    function __construct() {
    }

    //====Getters=====
    public getCity() {
        return $this->$city;
    }

    //===Setters=======
    public setCity($_city) {
        this $this->city = $_city;
    }
}
