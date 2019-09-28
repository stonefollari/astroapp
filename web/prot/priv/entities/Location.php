<?php 
namespace AstroApp\Web\Prot\Priv\Entities;
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
    public getCountry() {
        return $this->$country;
    }
	public getState() {
        return $this->$state;
    }
	public getCity() {
        return $this->$city;
    }
    //===Setters=======
    public setCountry($_country) {
        this $this->country = $_country;
    }
	public setState($_state) {
        this $this->state = $_state;
    }
	public setCity($_city) {
        this $this->city = $_city;
    }
}