<?php

// Acquires and stores the relevant time/date values.

class Times{
  var $UniversalTime = "0"; // For storing the universal time.
  var $DaysSinceEpoch = "0"; // For storing days since epoch.

  // Acquires the date/time information.
  function getTimes(){
    // Specific values for positions, relevant to the world time api query.
    $universalTimeBegin = 21;
    $universalTimeEnd = 5;
    $universalDateBegin = 10;
    $universalDateEnd = 19;

    // Query the world time api and store the result in a string.
    $dataReceiver = new DataReceiver;
    $dataStreamOutput = $dataReceiver->getDataFrom(WORLD_TIME, null);

    // Find the necessary data in the result string and save it in the specified variables.
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
