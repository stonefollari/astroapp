<?php namespace AstroApp.Entities
    class Location {
        private int $locationId;
        private String $country;
        private String $state;
        private String $city;
        
        function __construct() {
        }
        
        //====Getters=====
        public getCity() {
            return $this->$city;
        }
        
        //===Setters=======
        public setCity(String $_city) {
            this $this->city = $_city;
        }
    }
?>
