<?php

/*
  Acquires the coordinates on a Celestial Sphere for all the stars, the names of which are specified in
  the "star_name_input.txt". All those names that cannot be found are excluded from the results, but the
  first name in the list must be valid (it is therefore recommended to keep SIRIUS on the first line).
  Author: 56361160991438
*/

class CelestialCoordinates{

  // Acquires all the star connections from a storage and saves them into a string.
  private function getStarConnections(){
    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $starConnections = $dataReceiver->getDataFrom(NAMES_AND_CONNECTIONS, STAR_CONNECTIONS); // Acquire star connections from a storage.

    return $starConnections;
  }

  // Acquires all the star names from a storage and saves them into a string.
  private function getStarNames(){
    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $starNames = $dataReceiver->getDataFrom(NAMES_AND_CONNECTIONS, STAR_NAMES); // Acquire star names from a storage.

    // Return the array of star names.
    return $starNames;
  }

  // Creates a requirest for the SIMBAD database, based on the provided star names, and saved the result to
  // a string.
  private function getStarData($_starNames){

    $dataReceiver = new DataReceiver; // Create a new data receiver object.

    $dataStreamOutput = $dataReceiver->getDataFrom(ASTRONOMY, $_starNames); // Acquire star coordinates from an astronomical database.

    // Return the array of data.
    return $dataStreamOutput;
  }

  // Extracts star coordinates based on their position inside the string, which contains the output from the SIMBAD query.
  private function extractStarCoordinates($_data, $_starNames, $_starConnections, $_objects){

    // Variables for going through the query results.
    $x = 0;
    $starNumber = 0;

    $errorHeaderSize = 5; // The length of the error header message.
    $dataHeaderSize = 4; // The length of the data header message.

    while (!(substr($_data, $x, $dataHeaderSize) === "data")){$x++;} // Find the position where all the data begins.

    foreach ($_starNames as $starName){

      // Check if the name of the star is in the "error" section of the output and skip the star if so.
      $nextStar = 0;
      $errors = 0;
      while (true) {
        if (substr($_data, $errors, $errorHeaderSize) === "error"){break;}
        if (substr($_data, $errors, $dataHeaderSize) === "data"){break;}
        $errors++;
      }

      while (!(substr($_data, $errors, $dataHeaderSize) === "data")){
          if (substr($_data, $errors, $errorHeaderSize) === substr($starName, 0, 5)){$nextStar = 1; break;}
          $errors++;
      }

      //echo $starName, "\n";

      if ($nextStar == 1){continue;}

      while (!(substr($_data, $x, 1) === '*')){$x++;} // Find the position where the relevant data begins.

      //echo "\n";

      $rightAscensionBegin = DATA_BEGIN; // Assign the position of right ascension.
      $rightAscensionEnd = 0; // Store the position where right ascension string ends.
      while (!(substr($_data, $x + $rightAscensionBegin + $rightAscensionEnd, 1) === '~')){$rightAscensionEnd++;}

      $declinationBegin = $rightAscensionBegin + $rightAscensionEnd + 1; // Find where declination string begins.
      $declinationEnd = 0; // Store the position where declination string ends.
      while (!(substr($_data, $x + $declinationBegin + $declinationEnd, 1) === '~')){$declinationEnd++;}

      $rightAscension = "0".substr($_data, $x + $rightAscensionBegin, $rightAscensionEnd); // Extract right ascension.
      $declination = substr($_data, $x + $declinationBegin, $declinationEnd); // Extract declination.

      $_objects[CELESTIAL_DATA_OFFSET + $starNumber][NAME] = $starName;
      $_objects[CELESTIAL_DATA_OFFSET + $starNumber][VALUE] = $rightAscension;
      $_objects[CELESTIAL_DATA_OFFSET + $starNumber][ADDITIONAL] = $declination;
      $_objects[CELESTIAL_DATA_OFFSET + $starNumber][CONNECTION] = $_starConnections[$starNumber];
      $x++;
      $starNumber++;
    }

    // Return the modified array.
    return $_objects;
  }

  // Adds celestial coordinates to a provided array.
  public function addCelestialCoordinates($_objects){
    //get the names from the text document.
    $starNames = $this->getStarNames();

    // Get the connections from the text document.
    $starConnections = $this->getStarConnections();

    // Get the data from the SIMBAD.
    $dataStreamOutput = $this->getStarData($starNames);

    // Extract acquired data into the provided array.
    $_objects = $this->extractStarCoordinates($dataStreamOutput, $starNames, $starConnections, $_objects);

    // Return the modified array.
    return $_objects;
  }
}

?>
