<?php

function acquireGeneralData($UNIVERSAL_TIME, $DAYS_SINCE_EPOCH){
  $timeHoursBegin = 0;
  $timeHoursEnd = 2;
  $timeMinutesBegin = 3;
  $timeMinutesEnd = 5;

  $epochDaysBegin = 0;
  $epochDaysEnd = 4;
  $epochHoursBegin = 5;
  $epochHoursEnd = 7;
  $epochMinutesBegin = 9;
  $epochMinutesEnd = 11;

  $generalData = new stdClass();
  $generalData->name = "GENERAL DATA";
  $timeHours = (float)substr($UNIVERSAL_TIME, $timeHoursBegin, $timeHoursEnd);
  $timeMinutes = (float)substr($UNIVERSAL_TIME, $timeMinutesBegin, $timeMinutesEnd);
  $timeDegrees = convertToDegrees($timeHours, 0, $timeMinutes, 0, "+");
  $generalData->UT = array("UNIVERSAL TIME", $timeDegrees);

  $epochDays = (float)substr($DAYS_SINCE_EPOCH, $epochDaysBegin, $epochDaysEnd);
  $epochHours = (float)substr($DAYS_SINCE_EPOCH, $epochHoursBegin, $epochHoursEnd);
  $epochMinutes = (float)substr($DAYS_SINCE_EPOCH, $epochMinutesBegin, $epochMinutesEnd);
  $epochDecimal = convertTimeToDecimal($epochDays, $epochHours, $epochMinutes);
  $generalData->daysSinceEpoch = array("DAYS SINCE EPOCH", $epochDecimal);

  $generalData->sunCoordinates = solarCoordinates($generalData->daysSinceEpoch[VALUE]);
  $generalData->sunRA = convertToHours($generalData->sunCoordinates['rightAscention'], true);
  $generalData->sunDEC = convertToHours($generalData->sunCoordinates['declination'], false);
  $generalData->moonCoordinates = lunarCoordinates($generalData->daysSinceEpoch[VALUE]);
  $generalData->moonRA = convertToHours($generalData->moonCoordinates['rightAscention'], true);
  $generalData->moonDEC = convertToHours($generalData->moonCoordinates['declination'], false);

  $generalData->data = array($generalData->UT, $generalData->daysSinceEpoch);

  return $generalData;
}







?>
