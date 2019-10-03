<?php

function getTimes(){
  global $UNIVERSAL_TIME;
  global $DAYS_SINCE_EPOCH;

  $universalTimeBegin = 21;
  $universalTimeEnd = 5;

  $universalDateBegin = 10;
  $universalDateEnd = 19;

  $URL = "http://worldtimeapi.org/api/timezone/UTC.txt";
  $dataStream = curl_init();
  curl_setopt($dataStream, CURLOPT_URL, $URL);
  curl_setopt($dataStream, CURLOPT_RETURNTRANSFER, true);
  $dataStreamOutput = curl_exec($dataStream);

  $x = 0;
  while (substr($dataStreamOutput, $x, 8) != 'datetime'){$x++;}

  $UNIVERSAL_TIME = substr($dataStreamOutput, $x + $universalTimeBegin, $universalTimeEnd);

  date_default_timezone_set('UTC');
  $timeZone = new DateTimeZone(date_default_timezone_get());
  $epochTime = new DateTime("2000-01-01T00:00:00", $timeZone);
  $currentTime = new DateTime(gmdate(substr($dataStreamOutput, $x + $universalDateBegin, $universalDateEnd)), $timeZone);
  $DAYS_SINCE_EPOCH = $epochTime->diff($currentTime)->format('%a %h:%i');
}

?>
