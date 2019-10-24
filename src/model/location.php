<?php

/**
 * Description of location
 *
 * @author Gabriel
 */
class location {

    protected static $dataFile;

    public function __construct() {
        self::$dataFile = DATA . 'worldcities.csv';
    }

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

    function getLatLong($ID) {
        $array = null;
        if (($handle = fopen(DATA . 'worldcities.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[10] == $ID) {
                    $array[0] = $data[2];
                    $array[1] = $data[3];
                }
            }
            fclose($handle);
        }
        return json_encode($array);
    }

}
