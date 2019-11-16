<?php

// Acquires and stores the general data, such as days since epoch, as well as solar and lunar coordinates.
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

  function acquireGeneralData($universalTime, $daysSinceEpoch){
    // Create a new basic converter.
    $converter = new BasicConverter;

    // Acquire and store the time/date related values.
    $this->name = "GENERAL DATA";
    $timeHours = (float)substr($universalTime, self::$TIME_HOURS_BEGIN, self::$TIME_HOURS_END);
    $timeMinutes = (float)substr($universalTime, self::$TIME_MINUTES_BEGIN, self::$TIME_MINUTES_END);
    $timeDegrees = $converter->convertToDegrees($timeHours, 0, $timeMinutes, 0, "+");
    $this->UT = array("UNIVERSAL TIME", $timeDegrees);

    $epochDays = (float)substr($daysSinceEpoch, self::$EPOCH_DAYS_BEGIN, self::$EPOCH_DAYS_END);
    $epochHours = (float)substr($daysSinceEpoch, self::$EPOCH_HOURS_BEGIN, self::$EPOCH_HOURS_END);
    $epochMinutes = (float)substr($daysSinceEpoch, self::$EPOCH_MINUTES_BEGIN, self::$EPOCH_MINUTES_END);
    $epochDecimal = $converter->convertTimeToDecimal($epochDays, $epochHours, $epochMinutes);
    $this->daysSinceEpoch = array("DAYS SINCE EPOCH", $epochDecimal);

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

    $this->data = array($this->UT, $this->daysSinceEpoch);
  }
}

?>
