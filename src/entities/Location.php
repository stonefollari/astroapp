<?php

class Location {

    private $locationId;
    private $country;
    private $state;
    private $city;

    function __construct($_country, $_state, $_city, $_ID) {
        $this->country = $_country;
        $this->state = $_state;
        $this->city = $_city;
        $this->locationId = $_ID;
    }

    //====Getters=====
    public function getCountry() {
        return $this->$country;
    }

    public function getState() {
        return $this->$state;
    }

    public function getCity() {
        return $this->$city;
    }

    //===Setters=======
    public function setCountry($_country) {
        $this->country = $_country;
    }

    public function setState($_state) {
        $this->state = $_state;
    }

    public function setCity($_city) {
        $this->city = $_city;
    }

}
