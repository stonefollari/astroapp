<?php

//Acquires and stores the relevant time/date values.
class Times{
  var $UniversalTime = "0"; //for storing the universal time.
  var $DaysSinceEpoch = "0"; //for storing days since epoch.

  //acquires the date/time information.
  function getTimes(){
    //specific values for positions, relevant to the world time api query.
    $universalTimeBegin = 21;
    $universalTimeEnd = 5;
    $universalDateBegin = 10;
    $universalDateEnd = 19;

    //query the world time api and store the result in a string.
    $URL = "http://worldtimeapi.org/api/timezone/Etc/UTC.txt";
    $dataStream = curl_init();
    curl_setopt($dataStream, CURLOPT_URL, $URL);
    curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true);
    $dataStreamOutput = curl_exec($dataStream);

    //find the necessary data in the result string and save it in the specified variables.
    $x = 0;
    while (substr($dataStreamOutput, $x, 8) != 'datetime'){$x++;}
    $this->UniversalTime = substr($dataStreamOutput, $x + $universalTimeBegin, $universalTimeEnd);

    date_default_timezone_set('UTC');
    $timeZone = new DateTimeZone(date_default_timezone_get());
    $epochTime = new DateTime("2000-01-01T00:00:00", $timeZone);
    $currentTime = new DateTime(gmdate(substr($dataStreamOutput, $x + $universalDateBegin, $universalDateEnd)), $timeZone);
    $this->DaysSinceEpoch = $epochTime->diff($currentTime)->format('%a %h:%i');
  }
}

?>
