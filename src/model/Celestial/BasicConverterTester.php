<?php

/*
  For testing the output of the Basic Converter class.
  Author: 56361160991438
*/

class BasicConverterTester{

  // Store test cases for all the functions. For simplicity the number of cases should be five, which is maximum.
  private static $TEST_CASES = array(
    array(
      array(0, 5, 5, null, null),
      array(5, 0, 5, null, null),
      array(5, 0, 5, null, null)
    ),
    array(
      array(0, 0, 5, 0, '+'),
      array(5, 0, 0, 0, '-'),
      array(0, 5, 5, 0, ' '),
    ),
    array(
      array(0, 5, null, null, null),
      array(5, 0, null, null, null),
      array(0, -5, null, null, null)
    ),
    array(
      array(0, null, null, null, null),
      array(-5, null, null, null, null),
      array(5, null, null, null, null)
    ),
    array(
      array("LAT", "S", 0, null, null),
      array("LONG", "W", 5, null, null),
      array("LAT", "N", 5, null, null)
    )
  );

  // Store the expected output for the functions.
  private static $EXPECTED_OUTPUT = array(
    array(0, 5, 5),
    array(0, -5, 76),
    array('000-00-00', '+05-00-00', '000-00-00'),
    array(0, 355, 5),
    array(0, -5, 5)
  );

  /*
    Tests an individual function from a basic converter class and returns the results.
   */
  private function testFunction($_basicConverter, $_testFunction) {
    // Keep track of which case is being checked.
    $case = 0;
    // Store the results of the tests.
    $results = array();

    // Go through each expected output, checking the acquired result against it.
    foreach (self::$EXPECTED_OUTPUT[$_testFunction] as $currectExpectedOutput) {
      $firstParameter = self::$TEST_CASES[$_testFunction][$case][FIRST_PARAMETER];
      $secondParameter = self::$TEST_CASES[$_testFunction][$case][SECOND_PARAMETER];
      $thirdParameter = self::$TEST_CASES[$_testFunction][$case][THIRD_PARAMETER];
      $fourthParameter = self::$TEST_CASES[$_testFunction][$case][FOURTH_PARAMETER];
      $fifthParameter = self::$TEST_CASES[$_testFunction][$case][FIFTH_PARAMETER];

      // Send the values to a specific function and store the output.
      if ($_testFunction == TIME_TO_DECIMAL) {
        $output[$case] = $_basicConverter->convertTimeToDecimal($firstParameter, $secondParameter, $thirdParameter);
      }
      else if ($_testFunction == HOURS_TO_DEGREES) {
        $output[$case] = $_basicConverter->convertToDegrees($firstParameter, $secondParameter, $thirdParameter, $fourthParameter, $fifthParameter);
      }
      else if ($_testFunction == DEGREES_TO_HOURS) {
        $output[$case] = $_basicConverter->convertToHours($firstParameter, $secondParameter);
      }
      else if ($_testFunction == NORMALIZE_DEGREES) {
        $output[$case] = $_basicConverter->normalizeDegree($firstParameter);
      }
      else if ($_testFunction == NORMALIZE_COORDINATES) {
        $output[$case] = $_basicConverter->normalizeCoordinates($firstParameter, $secondParameter, $thirdParameter);
      }

      // Check the validity of the output against the expected output.
      // Integer approximation is close enough for these functions.
      if (intval($output[$case]) == self::$EXPECTED_OUTPUT[$_testFunction][$case]) {
        $results[$case] = "valid";
      }
      else {
        $results[$case] = "invalid";
      }

      $case++;
    }

    // Return results.
    return $results;
  }

  /*
    Test all the basic converter functions.
   */
  public function testBasicConverter($_basicConverter) {
    // Since this class is not a part of the main program, it needs to get definitions for itself separately.
    $definitions = new Definitions;
    $definitions->makeDefinitions();

    // Get the results from each individual function. This way helps with testing.
    $results[TIME_TO_DECIMAL] = $this->testFunction($_basicConverter, TIME_TO_DECIMAL);
    $results[HOURS_TO_DEGREES] = $this->testFunction($_basicConverter, HOURS_TO_DEGREES);
    $results[DEGREES_TO_HOURS] = $this->testFunction($_basicConverter, DEGREES_TO_HOURS);
    $results[NORMALIZE_DEGREES] = $this->testFunction($_basicConverter, NORMALIZE_DEGREES);
    $results[NORMALIZE_COORDINATES] = $this->testFunction($_basicConverter, NORMALIZE_COORDINATES);

    // Show the results to the console, for testing.
    foreach ($results as $result) {
      print_r($result);
      echo "\n";
    }
  }
}

?>
