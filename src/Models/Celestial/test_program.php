<?php
include 'Coordinates.php';

 // A coordinates object must be created, which contains the function to acquire all coordinates.
$coordinates = new Coordinates;
echo "loading\n";

// This function must be called in order to load a JSON array of coordinates.
// it requires latitude and longitude of the observer as the inputs.
$data = stripslashes(json_encode($coordinates->acquireAllCoordinates(36.07, 79.79)));
$data = str_replace('}","{', '},{', $data);
$data = str_replace('["', '[', $data);
$data = str_replace('"]', ']', $data);

echo $data;

?>
