<?php

namespace Astroapp\Src\Controller;

//This is the actual Controller Class
class LocationController {

    function __construct() {

    }

    /*
     * This function receives a Country, State, and City and returns
     * the data base ID for that location.
     */

    function _getLocationID($_country, $_state, $_city) {
        $ID = Locations::getLocationID($_country, $_state, $_city);
        return $ID;
    }

    /*
     * This function receives a location ID and returns the Latitude
     * and Longitude of the location.
     */

    function _getLatLong($ID) {
        return Locations::getLatLong($ID);
    }

}

//This is the Locations Repository, it should be in it's own file.
class Locations {
    /*
     * This function receives the parameters passed by the LocationController
     * creates a new location entity/model and return the ID for that location.
     */

    public static function getLocationID($_country, $_state, $_city) {
        $location = new locationModel($_country, $_state, $_city);
        $ID = $location->getLocationID();
        return $ID;
    }

    /*
     * This function takes the ID passed by the LocationController and returns
     * the lagitude and longitude of the specific location ID in the data base.
     */

    public static function getLatLong($ID) {
        $latLong = locationModel::getLatLong($ID);
        return json_encode($latLong);
    }

}

//This is the location model/entity, it should also be in it's own file.
class locationModel {

    private $country;
    private $state;
    private $city;

    //This construct could also set the locationID and the Lat Long.
    //That's a problem for future me.
    function __construct($_country, $_state, $_city) {
        $this->country = $_country;
        $this->state = $_state;
        $this->city = $_city;
    }

    //Business logic of getLocationID();
    //It will eventually work conversating with the data base.
    //So far it reads from the .csv file.
    function getLocationID() {
        $ID = null;
        if (($handle = fopen('worldcities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($this->country == $data[4] && $this->state == $data[7] && $this->city == $data[0] && $this->city == $data[1]) {
                    $ID = $data[10];
                }
            }
        }
        fclose($handle);
        return $ID;
    }

    //Same data base problem as in getLocationID();
    function getLatLong($ID) {
        $array = null;
        if (($handle = fopen('worldcities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[10] == $ID) {
                    $array[0] = $data[2];
                    $array[1] = $data[3];
                }
            }
            fclose($handle);
        }
        return $array;
    }

}

$_country = filter_input(INPUT_GET, 'country');
$_state = filter_input(INPUT_GET, 'state');
$_city = filter_input(INPUT_GET, 'city');

$controller = new LocationController();
$id = $controller->_getLocationID($_country, $_state, $_city);
echo $id;
$latLong = $controller->_getLatLong($id);
var_dump($latLong);

?>


