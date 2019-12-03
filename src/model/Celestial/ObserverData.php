<<<<<<< HEAD
<?php

/*
  Acquires and stores all the relative observer data, needed to find the relative coordinates of various celestial objects.
  Author: 56361160991438
*/

class ObserverData {
  public function acquireObserverData($_generalData, $_latitude, $_longitude){
    //$LATITUDE = "00.0000-N"; //degrees 00.0000-N
    //$LONGITUDE = "00.0000-E"; //degrees 00.0000-E
    $coordinateBegin = 0;
    $coordinateEnd = 7;

    // Create a new basic converter for handling simple unit convertsions.
    $converter = new BasicConverter;
    // Create a new converter for handing observer-related conversions.
    $relativeConverter = new RelativeConverter;

    // $latitude = normalizeCoordinates("LAT", substr($LATITUDE, $coordinateEnd + 1), (float)substr($LATITUDE, $coordinateBegin, $coordinateEnd));
    // $longitude = normalizeCoordinates("LONG", substr($LONGITUDE, $coordinateEnd + 1), (float)substr($LONGITUDE, $coordinateBegin, $coordinateEnd));
    $this->name = "OBSERVER DATA";
    $this->latitude = array("LAT", $_latitude, null);
    $this->longitude = array("LONG", $_longitude, null);
    // $this->LAT = array("LAT", $latitude, substr($LATITUDE, $coordinateEnd + 1));
    // $this->LONG = array("LONG", $longitude, substr($LONGITUDE, $coordinateEnd + 1));
    $localSiderealTime = $relativeConverter->siderealTime($_generalData->daysSinceEpoch[VALUE], $this->longitude[VALUE], $_generalData->UT[VALUE]);
    $localSiderealTIme = $converter->normalizeDegree($localSiderealTime);
    $this->LST = array("LST", $localSiderealTime);
    $this->data = array($this->latitude, $this->longitude, $this->LST);
  }
}

?>
=======
<?php

/*
  Acquires and stores all the relative observer data, needed to find the relative coordinates of various celestial objects.
  Author: 56361160991438
*/

class ObserverData {
  public function acquireObserverData($_generalData, $_latitude, $_longitude){
    //$LATITUDE = "00.0000-N"; //degrees 00.0000-N
    //$LONGITUDE = "00.0000-E"; //degrees 00.0000-E
    $coordinateBegin = 0;
    $coordinateEnd = 7;

    // Create a new basic converter for handling simple unit convertsions.
    $converter = new BasicConverter;
    // Create a new converter for handing observer-related conversions.
    $relativeConverter = new RelativeConverter;

    // $latitude = normalizeCoordinates("LAT", substr($LATITUDE, $coordinateEnd + 1), (float)substr($LATITUDE, $coordinateBegin, $coordinateEnd));
    // $longitude = normalizeCoordinates("LONG", substr($LONGITUDE, $coordinateEnd + 1), (float)substr($LONGITUDE, $coordinateBegin, $coordinateEnd));
    $this->name = "OBSERVER DATA";
    $this->latitude = array("LAT", $_latitude, null);
    $this->longitude = array("LONG", $_longitude, null);
    // $this->LAT = array("LAT", $latitude, substr($LATITUDE, $coordinateEnd + 1));
    // $this->LONG = array("LONG", $longitude, substr($LONGITUDE, $coordinateEnd + 1));
    $localSiderealTime = $relativeConverter->siderealTime($_generalData->daysSinceEpoch[VALUE], $this->longitude[VALUE], $_generalData->UT[VALUE]);
    $localSiderealTIme = $converter->normalizeDegree($localSiderealTime);
    $this->LST = array("LST", $localSiderealTime);
    $this->data = array($this->latitude, $this->longitude, $this->LST);
  }
}

?>
>>>>>>> b9220f8b02328bffa6f44673e5e57fa2783e1d1f
