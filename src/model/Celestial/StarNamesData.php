<?php

/*
  Gets basic star data from a text document.
  Author: 56361160991438
 */

class StarNamesData {

  /*
   Gets star names from a text document.
   */
  public function getStarNames() {
    $starNameInput = fopen(__DIR__ . '/star_name_input.txt', 'r'); // Gets all the text from the speicified file.

    $lineNumber = 0; // Keeps track of the line number.

    // Uploads all the names into an array.
    while ($line = fgets($starNameInput)) {

      $stopLine = 0; // For finding the end of the line.
      // If the current symbol is specified as the end of the line, break and keep the position.
      while (true) {
        $stopLine++;
        if (substr($line, $stopLine, 1) === '-') {
          break;
        }
        if (substr($line, $stopLine, 1) === '+') {
          break;
        }
      }

      $starNames[$lineNumber] = substr($line, 0, $stopLine); // Extract the star names from the text document.
      $lineNumber++; // Go to the next line.
    }

    // Close the input stream.
    fclose($starNameInput);

    return $starNames; // Return the data.
  }

  /*
    Gets star connection from a text document.
   */
  public function getStarConnections() {
    $starNameInput = fopen(__DIR__ . '/star_name_input.txt', 'r'); // Uploads all the text from the file.
    $lineNumber = 0; // Go to the first line.

    $nextConnected = 0; // Check if a star is connected to the next one in the text document.
    $lastConnected = 0; // Check if a star is not connected to the next one.

    // Go through the whole file, line by line.
    while ($line = fgets($starNameInput)) {

      $lastConnected = $nextConnected; // Keep track of whether the star is connected to the one before it.

      $stopLine = 0; // Keep track of where the line ends.
      $nextConnected = 0; // Keep track of whether it is connected to the other star.
      while (true) {
        $stopLine++;
        // Check for connection.
        if (substr($line, $stopLine, 1) === '-') {
          $nextConnected = 1;
          break;
        }
        if (substr($line, $stopLine, 1) === '+') {
          break;
        }
      }

      // Save the connection.
      $starConnections[$lineNumber] = null;
      if ($lastConnected == 1) {$starConnections[$lineNumber - 1] = substr($line, 0, $stopLine);}

      // Go to the next line.
      $lineNumber++;
    }

    fclose($starNameInput);

    return $starConnections;
  }

}

?>
