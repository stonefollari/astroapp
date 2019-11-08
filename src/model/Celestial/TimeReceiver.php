<?php

// Find out the current universal time.

class TimeReceiver{
  function getUniversalTime(){
    $URL = "http://worldtimeapi.org/api/timezone/Etc/UTC.txt";
    $dataStream = curl_init();
    curl_setopt($dataStream, CURLOPT_URL, $URL);
    curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true);
    $dataStreamOutput = curl_exec($dataStream);

    return $dataStreamOutput;
  }
}

?>
