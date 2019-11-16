<?php

// Acquires the coordinates on a Celestial Sphere for all the stars, the names of which are specified in
// the "star_name_input.txt". All those names that cannot be found are excluded from the results, but the
// first name in the list must be valid (it is therefore recommended to keep SIRIUS on the first line).

class CelestialCoordinates{

  // Acquires all the star connections from a storage and saves them into a string.
  function getStarConnections(){
    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $starConnections = $dataReceiver->getDataFrom(NAMES_AND_CONNECTIONS, STAR_CONNECTIONS); // Acquire star connections from a storage.

    return $starConnections;
  }

  // Acquires all the star names from a storage and saves them into a string.
  function getStarNames(){
    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $starNames = $dataReceiver->getDataFrom(NAMES_AND_CONNECTIONS, STAR_NAMES); // Acquire star names from a storage.

    // Return the array of star names.
    return $starNames;
  }

  // Creates a requirest for the SIMBAD database, based on the provided star names, and saved the result to
  // a string.
  function getStarData($starNames){

    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $dataStreamOutput = $dataReceiver->getDataFrom(ASTRONOMY, $starNames); // Acquire star coordinates from an astronomical database.

    // Return the array of data.
    return $dataStreamOutput;
  }

  // Extracts star coordinates based on their position inside the string, which contains the output from the SIMBAD query.
  function extractStarCoordinates($data, $starNames, $starConnections, $objects){

    $x = 0; $starNumber = 0; // Variables for going through the query results.

    while (!(substr($data, $x, 4) === "data")){$x++;} // Find the position where all the data begins.

    foreach ($starNames as $starName){

      // Check if the name of the star is in the "error" section of the output and skip the star if so.
      $nextStar = 0;
      $errors = 0;
      while (true) {
        if (substr($data, $errors, 5) === "error"){break;}
        if (substr($data, $errors, 4) === "data"){break;}
        $errors++;
      }
      while (!(substr($data, $errors, 4) === "data")){
          if (substr($data, $errors, 5) === substr($starName, 0, 5)){$nextStar = 1; break;}
          $errors++;
      }
      if ($nextStar == 1){continue;}

      while (!(substr($data, $x, 1) === '*')){$x++;} // Find the position where the relevant data begins.

      $rightAscensionBegin = DATA_BEGIN; // Assign the position of right ascension.
      $rightAscensionEnd = 0; // Store the position where right ascension string ends.
      while (!(substr($data, $x + $rightAscensionBegin + $rightAscensionEnd, 1) === '~')){$rightAscensionEnd++;}

      $declinationBegin = $rightAscensionBegin + $rightAscensionEnd + 1; // Find where declination string begins.
      $declinationEnd = 0; // Store the position where declination string ends.
      while (!(substr($data, $x + $declinationBegin + $declinationEnd, 1) === '~')){$declinationEnd++;}

      $rightAscension = "0".substr($data, $x + $rightAscensionBegin, $rightAscensionEnd); // Extract right ascension.
      $declination = substr($data, $x + $declinationBegin, $declinationEnd); // Extract declination.

      $objects[CELESTIAL_DATA_OFFSET + $starNumber][NAME] = $starName;
      $objects[CELESTIAL_DATA_OFFSET + $starNumber][VALUE] = $rightAscension;
      $objects[CELESTIAL_DATA_OFFSET + $starNumber][ADDITIONAL] = $declination;
      $objects[CELESTIAL_DATA_OFFSET + $starNumber][CONNECTION] = $starConnections[$starNumber];
      $x++;
      $starNumber++;
    }

    // Return the modified array.
    return $objects;
  }

  // Adds celestial coordinates to a provided array.
  function addCelestialCoordinates($objects){
    //get the names from the text document.
    $starNames = $this->getStarNames();

    // Get the connections from the text document.
    $starConnections = $this->getStarConnections();

    // Get the data from the SIMBAD.
    $dataStreamOutput = $this->getStarData($starNames);

    // Extract acquired data into the provided array.
    $objects = $this->extractStarCoordinates($dataStreamOutput, $starNames, $starConnections, $objects);

    // Return the modified array.
    return $objects;
  }
}

?>
