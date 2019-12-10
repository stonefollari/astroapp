<?php
include 'Coordinates.php'; // The main class, which produces the output.

/*
  This class is only used for testing.
  A coordinates object must be created, which contains the function to acquire all coordinates.
  Author: 56361160991438
 */

$coordinates = new Coordinates;
echo "loading\n";

$data = $coordinates->acquireAllCoordinates(36.07, 79.79);

/*
$basicConverter = new BasicConverter;
$basicConverterTester = new BasicConverterTester;
$basicConverterTester->testBasicConverter($basicConverter);
*/

echo $data;

?>
