<?php

// Gets data from different storages for other classes.

class DataReceiver{

  // Get data from various storages.
  function getDataFrom($source, $input){

    // Connect to an astronomical database if the source is specified as such.
    if ($source == ASTRONOMY){
      $astronomyDatabase = new AstronomyDatabase; // Create a new astronomy database connector.
      $data = $astronomyDatabase->getStarCoordinates($input); // Get celestial coordinates from a database.
    }

    // Connect to a basic star data storage if the source is specified as such.
    if ($source == NAMES_AND_CONNECTIONS){
      $starNamesData = new StarNamesData; // Create a new basic star data storage connector.
      if ($input == STAR_NAMES){$data = $starNamesData->getStarNames();} // Get the names of stars from the connector.
      if ($input == STAR_CONNECTIONS){$data = $starNamesData->getStarConnections();} // Get the connections of stars from the connector.
    }

    // Connect to a a universal time receiver.
    if ($source == WORLD_TIME){
      $timeReceiver = new TimeReceiver; // Create a new time receiver.
      $data = $timeReceiver->getUniversalTime(); // Get the current universal time from time receiver.
    }

    return $data; // Return data.

  }

}

?>
