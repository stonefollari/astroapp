<?php

/*
 * This is the location controller.
 * All user-side actions will be dealt with using this class.
 * This class should make use of the model named 'location'.
 * This model contains the methods related to the location inputs.
 * To declare the model in this class:
 * -----------------------------------
 * $this->model('modelName');
 * -----------------------------------
 * To declare the view related to the method:
 * -----------------------------------
 * $this->view('\viewFolder\viewFile', []);
 * $this->view->render();
 * 
 * @author: Gabriel H.C.O.
 * 
 * Last updated: 10/19/2019
 */

class LocationController extends Controller {
    /*
     * This controller function is to be called when the set location view
     * is to be rendered.
     */

    public function setLocation() {
        $this->model('location');
        $this->view('\location\setLocationTest', [$this->model->getCountries()]);
        $this->view->render();
    }

    /*
     * This controller function is to be called when the main display view
     * is to be rendered. The main display contains the javascript that is the
     * core of the website. So far this method transfers the Lat Long
     * coordinates of the user to the main page using a coockie, this, however,
     * might change in the near future.
     * All of the check conditions will also be transfered to individual methods
     * to make this function smaller.
     */

    public function displayLocation() {

        $_country = $_POST['country'];
        $_state = $_POST['state'];
        $_city = $_POST['city'];
        $this->model('location');
        $ID = $this->model->getLocationID($_country, $_state, $_city);
        if ($ID != null) {
            $data = $this->model->getLatLong($ID);
            $this->view('\home\ViewStars', $this->setDisplaySettings("false", "true", $data));
            $this->view->render();
        } else {
            $this->view('\location\setLocationTest', []);
            $this->view->render();
        }
    }

    /*
     * This is a helper function for displayLocation.
     * It sets the debug conditions and mouseControl for the home application.
     * It also takes the data array in JSON format to be appended with the
     * settings.
     */

    public function setDisplaySettings($debug, $mouseControl, $data) {
        $temp = json_decode($data);
        array_push($temp,"$debug","$mouseControl");
        $jsonData = json_encode($temp);
        return $jsonData;
    }

    public function locationJson() {
        $this->model('location');
        return $this->model->csvToJson(DATA . 'worldcities.csv');
    }

    /*
     * This function receives the country, state, and city as parameters and
     * returns the location ID related to it in the database.
     */

    public function getLocationID($_country, $_state, $_city) {
        $this->model('location');
        return $this->model->getLocationID($_country, $_state, $_city);
    }

    /*
     * This function receives the location ID as parameters and
     * returns the location lat long related to it in the database.
     */

    public function getLatLong($ID) {
        $this->model('location');
        return $this->model->getLatLong($ID);
    }

    public function getCountries() {
        $this->model('location');
        echo $this->model->getCountries();
    }

    public function getStates($country) {
        $country = urldecode($country);
        $this->model('location');
        echo $this->model->getStates($country);
    }

    public function getCities($country, $states) {
        $country = urldecode($country);
        $states = urldecode($states);
        $this->model('location');
        echo $this->model->getCities($country, $states);
    }

}
