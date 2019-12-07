<?php

/*
  This object contains various functions for handing basic unit conversions, such as hours to degrees.
  Author: 56361160991438
*/

class BasicConverter {

  // Converts date/time in days, hours and seconds to decimal format.
  public function convertTimeToDecimal($_days, $_hours, $_minutes){
    return $_days + ($_hours + $_minutes / 60) / 24;
  }

  // Convert hours, minutes and seconds to degrees, for both right ascesion and declination.
  public function convertToDegrees($_degrees, $_hours, $_minutes, $_seconds, $_sign){
    //echo $_hours, "  ", $_minutes, "  ", $_seconds, "\n";
    //$result = abs($_degrees + $_minutes / 60 + $_seconds / 3600) * ($_sign === "-" ? -1 : 1);
    //echo $result, "\n";
    if ($_hours == null) return abs($_degrees + $_minutes / 60 + $_seconds / 3600) * ($_sign === "-" ? -1 : 1);
    else return abs($_hours + $_minutes / 60 + $_seconds / 3600) * 15 * ($_sign === "-" ? -1 : 1);
  }

  // Convert right ascension to hours from degrees.
  public function convertToHours($_degrees, $_RA){
    if ($_RA == true){
      $_degrees /= 15;
    }
    $hours = (int)$_degrees;
    $minutes = (int)(($_degrees - $hours) * 60);
    $seconds = (int)(($minutes - ($_degrees - $hours) * 60) * 60);
    if ($_RA == false){
      if ($hours < 0 || $minutes < 0 || $seconds < 0){
        $result = "-";
      }
      else {$result = "+";}
      $result .= sprintf("%02d", abs($hours));
    }
    else {
      $result = sprintf("%03d", abs($hours));
    }
    $result .= "-";
    $result .= sprintf("%02d", abs($minutes));
    $result .= "-";
    $result .= sprintf("%02d", abs($seconds));

    return $result;
  }

  // Normalize degree value in the range from 0 to 360.
  public function normalizeDegree($_degree){
    while ($_degree < 0){
      $_degree += 360;
    }
    while ($_degree > 360){
      $_degree -= 360;
    }
    return $_degree;
  }

  // Normalize observer position coordinates, if given as a string.
  public function normalizeCoordinates($_type, $_hemisphere, $_value){
    if ($_type === "LAT" && $_hemisphere === "S"){
      return $_value * -1;
    }
    if ($_type === "LONG" && $_hemisphere === "W"){
      return $_value * -1;
    }
    return $_value;
  }
}

?>
