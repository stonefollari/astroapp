<?php

//gets names of stars from a text document (.txt)
function getStarNames(){
  $starNameInput = fopen(__DIR__ . '/star_name_input.txt', 'r');
  $lineNumber = 0;
  while ($line = fgets($starNameInput)){
    $starNames[$lineNumber] = substr($line, 0, -2);
    $lineNumber++;
  }
  fclose($starNameInput);

  return $starNames;
}

//get coordinate data about provided stars from simbad online database
function getStarData($starNames){
  $URL = 'http://simbad.u-strasbg.fr/simbad/sim-script?submit=submit+script&script=format+object+form1+%22*%3A+%25COO+end%22%0D%0A';
  foreach ($starNames as $starName){
    $URL .= 'query+id+';
    $URL .= $starName;
    $URL .= '%0D%0A';
  }
  $URL .= 'format+display';

  $dataStream = curl_init();
  curl_setopt($dataStream, CURLOPT_URL, $URL);
  curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true);
  $dataStreamOutput = curl_exec($dataStream);

  return $dataStreamOutput;
}

//extracts the coordinate values from the output string
function extractStarCoordinates($data, $starNames, $objects){
  $rightAscensionBegin = 3;
  $rightAscensionEnd = 8;
  $declinationBegin = 17;
  $declinationEnd = 9;

  $x = 0; $starNumber = 0;
  while (!(substr($data, $x, 4) === "data")){$x++;}
  foreach ($starNames as $starName){
    while (!(substr($data, $x, 1) === '*')){$x++;}
    $rightAscension = "0";
    $rightAscension .= substr($data, $x + $rightAscensionBegin, $rightAscensionEnd);
    $declination = substr($data, $x + $declinationBegin, $declinationBegin);
    $objects[2 + $starNumber][NAME] = $starName;
    $objects[2 + $starNumber][VALUE] = $rightAscension;
    $objects[2 + $starNumber][ADDITIONAL] = $declination;
    $x++; $starNumber++;
  }

  return $objects;
}

function addCelestialCoordinates($objects){
  $starNames = getStarNames();
  $dataStreamOutput = getStarData($starNames);
  $objects = extractStarCoordinates($dataStreamOutput, $starNames, $objects);
  return $objects;
}

?>
