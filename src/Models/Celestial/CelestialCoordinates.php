<?php

//Acquires the coordinates on a Celestial Sphere for all the stars, the names of which are specified in
//the "star_name_input.txt". All those names that cannot be found are excluded from the results, but the
//first name in the list must be valid (it is therefore recommended to keep SIRIUS on the first line).
class CelestialCoordinates{

  //Acquires all the star names from the "star_name_input.txt" and saves them into a string.
  function getStarNames(){
    $starNameInput = fopen(__DIR__ . '/star_name_input.txt', 'r'); //uploads all the text from the file.
    $lineNumber = 0;

    //uploads all the names into an array.
    while ($line = fgets($starNameInput)){
      $starNames[$lineNumber] = substr($line, 0, -2);
      $lineNumber++;
    }
    //close the input stream.
    fclose($starNameInput);

    //return the array of star names.
    return $starNames;
  }

  //Creates a requirest for the SIMBAD database, based on the provided star names, and saved the result to
  //a string.
  function getStarData($starNames){
    //make a query from the general information and provided star names.
    $URL = 'http://simbad.u-strasbg.fr/simbad/sim-script?submit=submit+script&script=format+object+form1+%22*%3A+%25COO+end%22%0D%0A';
    foreach ($starNames as $starName){
      $URL .= 'query+id+';
      $URL .= str_replace(' ', '+', $starName);
      $URL .= '%0D%0A';
    }
    $URL .= 'format+display';

    //save the acquired data into an array.
    $dataStream = curl_init();
    curl_setopt($dataStream, CURLOPT_URL, $URL);
    curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true);
    $dataStreamOutput = curl_exec($dataStream);

    //return the array of data.
    return $dataStreamOutput;
  }

  //Extracts star coordinates based on their position inside the string, which contains the output from the SIMBAD query.
  function extractStarCoordinates($data, $starNames, $objects){
    //specific positions, relevat to SIMBAD query (will be moved to static types).
    $rightAscensionBegin = 3;
    $rightAscensionEnd = 8;
    $declinationBegin = 17;
    $declinationEnd = 9;

    //variables for going through the query results.
    $x = 0;
    $starNumber = 0;
    //find the position where begins the data.
    while (!(substr($data, $x, 4) === "data")){$x++;}
    foreach ($starNames as $starName){
      //check if the name of the star is in the "error" section of the output and skip the star if so.
      $nextStar = 0;
      $errors = 0;
      while (!(substr($data, $errors, 5) === "error")){$errors++;}
      while (!(substr($data, $errors, 4) === "data")){
        if (substr($data, $errors, 5) === substr($starName, 0, 5)){$nextStar = 1; break;}
        $errors++;
      }
      if ($nextStar == 1){continue;}

      //find the position where the relevant data begins and save it into a provided array.
      while (!(substr($data, $x, 1) === '*')){$x++;}
      $rightAscension = "0";
      $rightAscension .= substr($data, $x + $rightAscensionBegin, $rightAscensionEnd);
      $declination = substr($data, $x + $declinationBegin, $declinationBegin);
      $objects[2 + $starNumber][NAME] = $starName;
      $objects[2 + $starNumber][VALUE] = $rightAscension;
      $objects[2 + $starNumber][ADDITIONAL] = $declination;
      $x++;
      $starNumber++;
    }

    //return the modified array.
    return $objects;
  }

  //Adds celestial coordinates to a provided array.
  function addCelestialCoordinates($objects){
    //get the names from the text document.
    $starNames = $this->getStarNames();
    //get the data from the SIMBAD.
    $dataStreamOutput = $this->getStarData($starNames);
    //extract acquired data into the provided array.
    $objects = $this->extractStarCoordinates($dataStreamOutput, $starNames, $objects);
    //return the modified array.
    return $objects;
  }
}

?>
