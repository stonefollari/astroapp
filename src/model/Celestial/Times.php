<?php

/*
  Acquires and stores the relevant time/date values.
  Author: 56361160991438
 */

class Times {
  var $UniversalTime = "0"; // For storing the universal time.
  var $DaysSinceEpoch = "0"; // For storing days since epoch.

  // Specific values for positions, relevant to the world time api query.
  public static $UNIVERSAL_TIME_BEGIN = 21;
  public static $UNIVERSAL_TIME_END = 5;
  public static $UNIVERSAL_DATE_BEGIN = 10;
  public static $UNIVERSAL_DATE_END = 19;

  /*
    Acquires the date/time information.
   */
    public function getTimes() {
    // Query the world time api and store the result in a string.
    $dataReceiver = new DataReceiver;
    $dataStreamOutput = $dataReceiver->getDataFrom(WORLD_TIME, null);

    // Find the necessary data in the result string and save it in the specified variables.
    $x = 0;
    while (substr($dataStreamOutput, $x, 8) != 'datetime'){$x++;}
    $this->UniversalTime = substr($dataStreamOutput, $x + self::$UNIVERSAL_TIME_BEGIN, self::$UNIVERSAL_TIME_END);

    date_default_timezone_set('UTC'); // Set the default time zone to the Universal Time.
    $timeZone = new DateTimeZone(date_default_timezone_get()); // Set the time zone to the Universal Time.
    $epochTime = new DateTime("2000-01-01T00:00:00", $timeZone); // Get the epoch time from the standard php funciton.

    // Extract the current universal time from the received string.
    $currentTime = new DateTime(gmdate(substr($dataStreamOutput, $x + self::$UNIVERSAL_DATE_BEGIN, self::$UNIVERSAL_DATE_END)), $timeZone);

    //Add days since epoch string, in a corrent format, to the object, created from this class.
    $this->DaysSinceEpoch = $epochTime->diff($currentTime)->format('%a %h:%i');
  }
}

?>
