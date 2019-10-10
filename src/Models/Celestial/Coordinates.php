<?php
include 'Times.php';

include 'CelestialCoordinates.php'; //non-relative celestial coordinates.
include 'SolarCoordinates.php'; //non-relative solar coordinates.
include 'LunarCoordinates.php'; //non-relative lunar cooridnates.

include 'BasicConverter.php'; //basic conversion (such as degrees to hours).
include 'RelativeConverter.php'; //relative conversions (such as universal to sidereal time).

include 'GeneralData.php'; //general data (such as days since epoch).
include 'ObserverData.php'; //observer data (such as latitude).
include 'ObjectData.php'; //non-relative object coordinates.

include 'TestOutput.php'; //extended console data output.

$latitude = 0; $longitude = 0;

$UNIVERSAL_TIME = "0";
$DAYS_SINCE_EPOCH = "0";

//Combines the results from all the other functions and converts these to a JSON array.
class Coordinates {
  function acquireAllCoordinates($latitude, $longitude){
    $testOutput = new TestOutput; //for displaying extended information in the console.

    $objects = array(array("SUN", null, null), array("MOON", null, null)); //an array, which is to contain all the necessary objects.
    $output = array(null);

    //specify the specific location of data inside the array
    define("NAME", 0);
    define("VALUE", 1);
    define("ADDITIONAL", 2);

    //create an object, which will add all non-relative celestial coordinates into the main array.
    $celestialCoordinates = new CelestialCoordinates;
    $objects = $celestialCoordinates->addCelestialCoordinates($objects);

    //create an object, which will acquire and contain all the necessary time/date information.
    $times = new Times();
    $times->getTimes();

    //create an object, which will acquire all the general data, such as days since epoch, and solar/lunar coordinates.
    $generalData = new GeneralData;
    $generalData->acquireGeneralData($times->UniversalTime, $times->DaysSinceEpoch);

    //create an object, whihc will contain all the observer data.
    $observerData = new ObserverData;
    $observerData->acquireObserverData($generalData, $latitude, $longitude);

    //$testOutput->displayData(array($generalData, $observerData) , null);

    $objectNumber = 0;
    foreach ($objects as $object){
      $objectData = new ObjectData;
      $objectData->acquireObjectData($object, $generalData, $observerData); //convert all the data from non-relative to relative coordinates.
      //encode all the data in json format.
      $output[$objectNumber] = json_encode(array('name' => $objectData->objectName[VALUE], 'right ascension' => $objectData->RA[VALUE], 'declination' => $objectData->DEC[VALUE], 'altitude' => $objectData->ALT[VALUE], 'azimuth' => $objectData->AZ[VALUE], 'connection' => null));
      $objectNumber++;

      //$testOutput->displayData(array($objectData), 3);
    }

    //return the encoded data for all objects.
    return $output;
  }
}

?>
