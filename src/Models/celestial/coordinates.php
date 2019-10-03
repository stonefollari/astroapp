<?php
include 'times.php';

include 'celestial_coordinates.php';
include 'solar_coordinates.php';
include 'lunar_coordinates.php';

include 'basic_conversions.php';
include 'relative_conversions.php';

include 'general_data.php';
include 'observer_data.php';
include 'object_data.php';

include 'test_output.php';

$latitude = 0; $longitude = 0;
//echo "\n"; $line = 10; while ($line > 0){echo "*\n\n"; $line--;}

function getCelestialCoordinates($latitude, $longitude){
  $objects = array(array("SUN", null, null), array("MOON", null, null));
  $output = array(null);

  $UNIVERSAL_TIME = "0";
  $DAYS_SINCE_EPOCH = "0";

  define("NAME", 0);
  define("VALUE", 1);
  define("ADDITIONAL", 2);

  $objects = addCelestialCoordinates($objects);
  getTimes();

  $generalData = new stdClass();
  $generalData = acquireGeneralData($UNIVERSAL_TIME, $DAYS_SINCE_EPOCH);

  $observerData = new stdClass();
  $observerData = acquireObserverData($generalData, $latitude, $longitude);

  //displayData(array($generalData, $observerData) , null);

  $objectNumber = 0;
  foreach ($objects as $object){
    $objectData = new stdClass();
    $objectData = acquireObjectData($object, $generalData, $observerData);
    $output[$objectNumber] = json_encode(array('name' => $objectData->objectName[VALUE], 'right ascension' => $objectData->RA[VALUE], 'declination' => $objectData->DEC[VALUE], 'altitude' => $objectData->ALT[VALUE], 'azimuth' => $objectData->AZ[VALUE], 'connection' => null));
    $objectNumber++;

    //displayData(array($objectData), 3);
  }

  return $output;
}

?>
