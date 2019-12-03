<<<<<<< HEAD
<?php

/*
  For testing the output of the Basic Converter class.
  Author: 56361160991438
*/

class BasicConverterTester{

  // Test the time to decimal conversion funciton.
  private function testConvertTimeToDecimal($_basicConverter){

    // Define edge cases.
    $edgeCases = array(
      array(0, 5, 5),
      array(5, 0, 5),
      array(5, 5, 0),
    );

    // Define expected output for each edge case, as an integer.
    $expectedOutput = array(0, 5, 5);

    // Set the current test result to false.
    $output = array("invalid", "invalid", "invalid");

    $case = 0; // Keep track of which case is being tested.

    foreach ($expectedOutput as $currentExpectedOutput){
      // Check that the acquired value is close to the expected one.
      if (intval($_basicConverter->convertTimeToDecimal($edgeCases[$case][0], $edgeCases[$case][1], $edgeCases[$case][2])) == $currentExpectedOutput){
        $output[$case] = "valid";
      }
      $case++;
    }

    // Return the output, containing test results.
    return $output;
  }

  // Test all the basic converter functions.
  public function testBasicConverter($_basicConverter){
    // Get the results of the time to decimal conversion test and output them to the console.
    $output = $this->testConvertTimeToDecimal($_basicConverter);
    print_r($output);
    echo "\n";
  }
}

?>
=======
<?php

/*
  For testing the output of the Basic Converter class.
  Author: 56361160991438
*/

class BasicConverterTester{

  // Test the time to decimal conversion funciton.
  private function testConvertTimeToDecimal($_basicConverter){

    // Define edge cases.
    $edgeCases = array(
      array(0, 5, 5),
      array(5, 0, 5),
      array(5, 5, 0),
    );

    // Define expected output for each edge case, as an integer.
    $expectedOutput = array(0, 5, 5);

    // Set the current test result to false.
    $output = array("invalid", "invalid", "invalid");

    $case = 0; // Keep track of which case is being tested.

    foreach ($expectedOutput as $currentExpectedOutput){
      // Check that the acquired value is close to the expected one.
      if (intval($_basicConverter->convertTimeToDecimal($edgeCases[$case][0], $edgeCases[$case][1], $edgeCases[$case][2])) == $currentExpectedOutput){
        $output[$case] = "valid";
      }
      $case++;
    }

    // Return the output, containing test results.
    return $output;
  }

  // Test all the basic converter functions.
  public function testBasicConverter($_basicConverter){
    // Get the results of the time to decimal conversion test and output them to the console.
    $output = $this->testConvertTimeToDecimal($_basicConverter);
    print_r($output);
    echo "\n";
  }
}

?>
>>>>>>> b9220f8b02328bffa6f44673e5e57fa2783e1d1f
