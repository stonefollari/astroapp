<?php

//Acquires and stores the general data, such as days since epoch, as well as solar and lunar coordinates.
class GeneralData {
  //specific values of positions, relevant to the various functions outputs.
  private static $timeHoursBegin = 0;
  private static $timeHoursEnd = 2;
  private static $timeMinutesBegin = 3;
  private static $timeMinutesEnd = 5;

  private static $epochDaysBegin = 0;
  private static $epochDaysEnd = 4;
  private static $epochHoursBegin = 5;
  private static $epochHoursEnd = 7;
  private static $epochMinutesBegin = 9;
  private static $epochMinutesEnd = 11;

  function acquireGeneralData($universalTime, $daysSinceEpoch){
    //create a new basic converter.
    $converter = new BasicConverter;

    //acquire and store the time/date related values.
    $this->name = "GENERAL DATA";
    $timeHours = (float)substr($universalTime, self::$timeHoursBegin, self::$timeHoursEnd);
    $timeMinutes = (float)substr($universalTime, self::$timeMinutesBegin, self::$timeMinutesEnd);
    $timeDegrees = $converter->convertToDegrees($timeHours, 0, $timeMinutes, 0, "+");
    $this->UT = array("UNIVERSAL TIME", $timeDegrees);

    $epochDays = (float)substr($daysSinceEpoch, self::$epochDaysBegin, self::$epochDaysEnd);
    $epochHours = (float)substr($daysSinceEpoch, self::$epochHoursBegin, self::$epochHoursEnd);
    $epochMinutes = (float)substr($daysSinceEpoch, self::$epochMinutesBegin, self::$epochMinutesEnd);
    $epochDecimal = $converter->convertTimeToDecimal($epochDays, $epochHours, $epochMinutes);
    $this->daysSinceEpoch = array("DAYS SINCE EPOCH", $epochDecimal);

    //create new objects, which will estimate and provide solar and lunar coordinates.
    $solarCoordinates = new SolarCoordinates;
    $lunarCoordinates = new LunarCoordinates;

    //acquire, convert and store solar coordinates.
    $this->sunCoordinates = $solarCoordinates->getSolarCoordinates($this->daysSinceEpoch[VALUE]);
    $this->sunRA = $converter->convertToHours($this->sunCoordinates['rightAscention'], true);
    $this->sunDEC = $converter->convertToHours($this->sunCoordinates['declination'], false);

    //acquire, convert and store lunar coordinates.
    $this->moonCoordinates = $lunarCoordinates->getLunarCoordinates($this->daysSinceEpoch[VALUE]);
    $this->moonRA = $converter->convertToHours($this->moonCoordinates['rightAscention'], true);
    $this->moonDEC = $converter->convertToHours($this->moonCoordinates['declination'], false);

    $this->data = array($this->UT, $this->daysSinceEpoch);
  }
}

?>
