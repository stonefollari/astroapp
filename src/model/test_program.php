<?php
include 'Coordinates.php'; // The main object, which produces the output.

/*
  A coordinates object must be created, which contains the function to acquire all coordinates.
  Author: 56361160991438
*/

$coordinates = new Coordinates;
echo "loading\n";

//This function must be called in order to load a JSON array of coordinates.
//it requires latitude and longitude of the observer as the inputs.
//$data = stripslashes(json_encode($coordinates->acquireAllCoordinates(36.07, 79.79)));
//$data = str_replace('}","{', '},{', $data);
//$data = str_replace('["', '[', $data);
//$data = str_replace('"]', ']', $data);

$data = $coordinates->acquireAllCoordinates(36.07, 79.79);

//$basicConverter = new BasicConverter;
//$basicConverterTester = new BasicConverterTester;
//$basicConverterTester->testBasicConverter($basicConverter);

echo $data;

?>
