<?php

/*
  Acquires and stores the general data, such as days since epoch, as well as solar and lunar coordinates.
  Author: 56361160991438
*/

class GeneralData {

  // Specific values of positions, relevant to the various functions outputs.
  private static $TIME_HOURS_BEGIN = 0;
  private static $TIME_HOURS_END = 2;
  private static $TIME_MINUTES_BEGIN = 3;
  private static $TIME_MINUTES_END = 5;

  private static $EPOCH_DAYS_BEGIN = 0;
  private static $EPOCH_DAYS_END = 4;
  private static $EPOCH_HOURS_BEGIN = 5;
  private static $EPOCH_HOURS_END = 7;
  private static $EPOCH_MINUTES_BEGIN = 9;
  private static $EPOCH_MINUTES_END = 11;

  public function acquireGeneralData($_universalTime, $_daysSinceEpoch){
    // Create a new basic converter.
    $converter = new BasicConverter;

    // Acquire and store the time/date related values.
    $this->name = "GENERAL DATA";
    $timeHours = (float)substr($_universalTime, self::$TIME_HOURS_BEGIN, self::$TIME_HOURS_END); // Get the hours from the specified position in the string.
    $timeMinutes = (float)substr($_universalTime, self::$TIME_MINUTES_BEGIN, self::$TIME_MINUTES_END); // Get the minutes from the specified position in the string.
    $timeDegrees = $converter->convertToDegrees($timeHours, 0, $timeMinutes, 0, "+"); // Convert the acquired time to degrees.
    $this->UT = array("UNIVERSAL TIME", $timeDegrees); // Add uniersal time to the object, created through this class.

    $epochDays = (float)substr($_daysSinceEpoch, self::$EPOCH_DAYS_BEGIN, self::$EPOCH_DAYS_END); // Get the epoch days from the specified position in the string.
    $epochHours = (float)substr($_daysSinceEpoch, self::$EPOCH_HOURS_BEGIN, self::$EPOCH_HOURS_END); // Get the epoch hours from the specified position in the string.
    $epochMinutes = (float)substr($_daysSinceEpoch, self::$EPOCH_MINUTES_BEGIN, self::$EPOCH_MINUTES_END); // Get the epoch minutes from the specified position in the string.
    $epochDecimal = $converter->convertTimeToDecimal($epochDays, $epochHours, $epochMinutes); // Convert the current time since epoch to the decimal format.
    $this->daysSinceEpoch = array("DAYS SINCE EPOCH", $epochDecimal); // Add the time since epoch to the object, created through this class.

    // Create new objects, which will estimate and provide solar and lunar coordinates.
    $solarCoordinates = new SolarCoordinates;
    $lunarCoordinates = new LunarCoordinates;

    // Acquire, convert and store solar coordinates.
    $this->sunCoordinates = $solarCoordinates->getSolarCoordinates($this->daysSinceEpoch[VALUE]);
    $this->sunRA = $converter->convertToHours($this->sunCoordinates['rightAscention'], true);
    $this->sunDEC = $converter->convertToHours($this->sunCoordinates['declination'], false);

    // Acquire, convert and store lunar coordinates.
    $this->moonCoordinates = $lunarCoordinates->getLunarCoordinates($this->daysSinceEpoch[VALUE]);
    $this->moonRA = $converter->convertToHours($this->moonCoordinates['rightAscention'], true);
    $this->moonDEC = $converter->convertToHours($this->moonCoordinates['declination'], false);

    $this->data = array($this->UT, $this->daysSinceEpoch); //Combine the acquired values into an array.
  }
}

?>
