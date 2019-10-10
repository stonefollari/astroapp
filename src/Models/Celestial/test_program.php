<?php
include 'Coordinates.php';

 //a coordinates object must be created, which contains the function to acquire all coordinates
$coordinates = new Coordinates;
echo "loading\n";
//this function must be called in order to load a JSON array of coordinates.
//it requires latitude and longitude of the observer as the inputs.
$data = $coordinates->acquireAllCoordinates(0, 0);

//for testing, displays all the coordinates as JSON objects
foreach ($data as $objectData){
  echo $objectData, "\n";
}

?>
