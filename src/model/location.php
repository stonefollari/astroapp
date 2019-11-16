<?php

/*
 * This is the location model.
 * All of the location controller's methods may make use of this class.
 * This model has the follow structure:
 * -----------------------------------
 * dataBase (dataFile)
 * ------------------------------------
 * It also contains the following methods:
 * ------------------------------------
 * getLocationID($_country, $_state, $_city)
 * function getLatLong($ID)
 * ------------------------------------
 * These methods should be accessible from the location controller.
 * @author Gabriel H.C.O.
 */
class location {

    protected static $dataFile;

    public function __construct() {
        self::$dataFile = DATA . 'worldcities.csv';
    }

    /*
     * This function finds the location ID related to $_country, $_state, $_city
     * parameters passed. It searches for the location in the database, .csv file.
     */
    public function getLocationID($_country, $_state, $_city) {
        $ID = null;
        if (($handle = fopen(DATA . 'worldcities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($_country == $data[4] && $_state == $data[7] && $_city == $data[0] && $_city == $data[1]) {
                    $ID = $data[10];
                }
            }
        }
        return $ID;
    }
    /*
     * This function retrieves the lat long in JSON format based on a location ID
     * passed as the parameter. It searches for the location in the database, .csv file.
     */
    function getLatLong($ID) {
        $array = null;
        if (($handle = fopen(DATA . 'worldcities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[10] == $ID) {
                    $array[0] = (int)$data[2];
                    $array[1] = (int)$data[3];
                }
            }
            fclose($handle);
        }
        return json_encode($array);
    }

}
