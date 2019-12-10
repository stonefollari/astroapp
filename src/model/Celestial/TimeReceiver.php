<?php

/*
  Find out the current universal time.
  Author: 56361160991438
 */

class TimeReceiver {
  /* 
    Acquires the universal time from the world time api.
   */
  public function getUniversalTime() {
    $URL = "http://worldtimeapi.org/api/timezone/Etc/UTC.txt"; // Set the url to the world time api.
    $dataStream = curl_init(); // Create a new standard php data stream.
    curl_setopt($dataStream, CURLOPT_URL, $URL); // Set the data stream to the provided url.
    curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true); // Allow to view data received.
    $dataStreamOutput = curl_exec($dataStream); // Receive the data and store it in a string.

    return $dataStreamOutput; // Return the string.
  }
}

?>
