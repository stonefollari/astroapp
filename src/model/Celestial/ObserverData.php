<?php

/*
  Acquires and stores all the relative observer data, needed to find the relative coordinates of various celestial objects.
  Author: 56361160991438
 */

class ObserverData {


  /* Acquires and converts observer data, such as local sidereal time and latitude. */
  public function acquireObserverData($_generalData, $_latitude, $_longitude) {
    // Create a new basic converter for handling simple unit convertsions.
    $converter = new BasicConverter;
    // Create a new converter for handing observer-related conversions.
    $relativeConverter = new RelativeConverter;

    // Store latitude and longitude.
    $this->name = "OBSERVER DATA";
    $this->latitude = array("LAT", $_latitude, null);
    $this->longitude = array("LONG", $_longitude, null);

    // Convert and normalize current universal time to sidereal time.
    $localSiderealTime = $relativeConverter->siderealTime($_generalData->daysSinceEpoch[VALUE], $this->longitude[VALUE], $_generalData->UT[VALUE]);
    $localSiderealTIme = $converter->normalizeDegree($localSiderealTime);

    // Store the local sidereal time.
    $this->LST = array("LST", $localSiderealTime);

    // Combine all the data together.
    $this->data = array($this->latitude, $this->longitude, $this->LST);
  }
}

?>
