<?php

$latitude = 0; $longitude = 0; // Hold latitude and longitude.

$UNIVERSAL_TIME = "0"; // Holds the universal time.
$DAYS_SINCE_EPOCH = "0"; // Holds days since epoch.

/*
  Combines the results from all the other functions and converts these to a JSON array.
  Author: 56361160991438
*/

class Coordinates {
  public function acquireAllCoordinates($_latitude, $_longitude){
    $definitions = new Definitions; // Specifies various definitions for other classes.
    $definitions->makeDefinitions(); // Make defintions.

    $testOutput = new TestOutput; // For displaying extended information in the console.

    $objects = array(array("SUN", null, null, null), array("MOON", null, null, null)); //an array, which is to contain all the necessary objects.
    $output = array(null);

    // Create an object, which will add all non-relative celestial coordinates into the main array.
    $celestialCoordinates = new CelestialCoordinates;
    $objects = $celestialCoordinates->addCelestialCoordinates($objects);

    // Create an object, which will acquire and contain all the necessary time/date information.
    $times = new Times();
    $times->getTimes();

    // Create an object, which will acquire all the general data, such as days since epoch, and solar/lunar coordinates.
    $generalData = new GeneralData;
    $generalData->acquireGeneralData($times->UniversalTime, $times->DaysSinceEpoch);

    // Create an object, whihc will contain all the observer data.
    $observerData = new ObserverData;
    $observerData->acquireObserverData($generalData, $_latitude, $_longitude);

    // $testOutput->displayData(array($generalData, $observerData) , null);

    $objectNumber = 0;
    foreach ($objects as $object){
      $objectData = new ObjectData;
      $objectData->acquireObjectData($object, $generalData, $observerData); //convert all the data from non-relative to relative coordinates.

      // Encode all the data in json format.
      $output[$objectNumber] = json_encode(array('name' => $objectData->objectName[VALUE], 'right ascension' => $objectData->RA[VALUE], 'declination' => $objectData->DEC[VALUE], 'altitude' => $objectData->ALT[VALUE], 'azimuth' => $objectData->AZ[VALUE], 'connection' => $objectData->CONNECTION[VALUE]));
      $objectNumber++;

      // $testOutput->displayData(array($objectData), 3);
    }

    $output = stripslashes(json_encode($output));
    $output = str_replace('}","{', '},{', $output);
    $output = str_replace('["', '[', $output);
    $output = str_replace('"]', ']', $output);

    //echo $output;

    // Return the encoded data for all objects.
    return $output;
  }
}

?>
