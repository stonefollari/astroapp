<?php

function acquireObserverData($generalData, $latitude, $longitude){
  //$LATITUDE = "00.0000-N"; //degrees 00.0000-N
  //$LONGITUDE = "00.0000-E"; //degrees 00.0000-E
  $coordinateBegin = 0;
  $coordinateEnd = 7;

  $observerData = new stdClass();
  //$latitude = normalizeCoordinates("LAT", substr($LATITUDE, $coordinateEnd + 1), (float)substr($LATITUDE, $coordinateBegin, $coordinateEnd));
  //$longitude = normalizeCoordinates("LONG", substr($LONGITUDE, $coordinateEnd + 1), (float)substr($LONGITUDE, $coordinateBegin, $coordinateEnd));
  $observerData->name = "OBSERVER DATA";
  $observerData->LAT = array("LAT", $latitude, null);
  $observerData->LONG = array("LONG", $longitude, null);
  //$observerData->LAT = array("LAT", $latitude, substr($LATITUDE, $coordinateEnd + 1));
  //$observerData->LONG = array("LONG", $longitude, substr($LONGITUDE, $coordinateEnd + 1));
  $localSiderealTime = siderealTime($generalData->daysSinceEpoch[VALUE], $observerData->LONG[VALUE], $generalData->UT[VALUE]);
  $localSiderealTIme = normalizeDegree($localSiderealTime);
  $observerData->LST = array("LST", $localSiderealTime);
  $observerData->data = array($observerData->LAT, $observerData->LONG, $observerData->LST);

  return $observerData;
}

?>
