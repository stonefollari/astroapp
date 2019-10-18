<?php
//This is where the location model will live.
//Nothing to see here so far.
namespace AstroApp\Src\Models;

    class locationModel {

        private $country;
        private $state;
        private $city;
        private $locationID;
        private $lat;
        private $long;
        function __construct($_country, $_state, $_city) {
        $this->country = $_country;
        $this->state = $_state;
        $this->city = $_city;
        $this->locationID = getLocationID();
        }
        function getLocationID() {
            if(($handle = fopen("worldcities.csv", ",") !== false)) {
                while ($data = fgetc($handle) !== false) {
                    $id = $data[10];
                }
            }
            return $id;
        }
        function getLatLong() {

        }
        function loadDataBase(){

        }
    }

