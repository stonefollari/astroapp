<?php

// Acquires star data from an astronomical database.

class AstronomyDatabase{

  // Make a query for the SIMBAD astronomical database from given star names, which requests right ascension and declination.
  function makeQuery($starNames){
    $URL = 'http://simbad.u-strasbg.fr/simbad/sim-script?submit=submit+script&script=format+object+form1+%22*%3A+%25COO(A~D)~%22%0D%0A';

    // Add star names one by one to the query string.
    foreach ($starNames as $starName){
      $URL .= 'query+id+';
      $URL .= str_replace(' ', '+', $starName);
      $URL .= '%0D%0A';
    }
    $URL .= 'format+display';

    return $URL; // Return the query string.
  }

  // Gets data from a given URL.
  function getData($URL){
    $dataStream = curl_init(); // Create a new data stream.
    curl_setopt($dataStream, CURLOPT_URL, $URL); // Specify the data stream as a URL.
    curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true); // Allow for display of the acquired data.
    $dataStreamOutput = curl_exec($dataStream); // Execute the data stream.

    return $dataStreamOutput; // Return the output from the data stream.
  }

  // Gets celestial coordinates for star, which names are given.
  function getStarCoordinates($starNames){
    $URL = $this->makeQuery($starNames); // Make a query string based on star names.
    $dataStreamOutput = $this->getData($URL); // Get the celestial coordinates.

    return $dataStreamOutput; // Return the data.
  }

}








?>
