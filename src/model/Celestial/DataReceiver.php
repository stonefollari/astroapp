<?php

/*
  Gets data from different storages for other classes.
  Author: 56361160991438
 */

class DataReceiver{

  /*
   Get data from various storages.
   */
  public function getDataFrom($_source, $_input) {

    // Connect to an astronomical database if the source is specified as such.
    if ($_source == ASTRONOMY) {
      $astronomyDatabase = new AstronomyDatabase; // Create a new astronomy database connector.
      $data = $astronomyDatabase->getStarCoordinates($_input); // Get celestial coordinates from a database.
    }

    // Connect to a basic star data storage if the source is specified as such.
    if ($_source == NAMES_AND_CONNECTIONS) {
      $starNamesData = new StarNamesData; // Create a new basic star data storage connector.

      // Get the names of stars from the connector.
      if ($_input == STAR_NAMES) {
        $data = $starNamesData->getStarNames();
      }

      // Get the connections of stars from the connector.
      if ($_input == STAR_CONNECTIONS) {
        $data = $starNamesData->getStarConnections();
      }
    }

    // Connect to a a universal time receiver.
    if ($_source == WORLD_TIME) {
      $timeReceiver = new TimeReceiver; // Create a new time receiver.
      $data = $timeReceiver->getUniversalTime(); // Get the current universal time from time receiver.
    }

    return $data; // Return data.

  }

}

?>
