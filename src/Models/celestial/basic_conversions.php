<?php
function convertTimeToDecimal($days, $hours, $minutes){
  return $days + ($hours + $minutes / 60) / 24;
}

function convertToDegrees($degrees, $hours, $minutes, $seconds, $sign){
  $result = abs($degrees + $minutes / 60 + $seconds / 3600) * ($sign === "-" ? -1 : 1);
  if ($hours == null) return abs($degrees + $minutes / 60 + $seconds / 3600) * ($sign === "-" ? -1 : 1);
  else return abs($hours + $minutes / 60 + $seconds / 3600) * 15 * ($sign === "-" ? -1 : 1);
}

function convertToHours($degrees, $RA){
  if ($RA == true){$degrees /= 15;}
  $hours = (int)$degrees;
  $minutes = (int)(($degrees - $hours) * 60);
  $seconds = (int)(($minutes - ($degrees - $hours) * 60) * 60);
  if ($RA == false){
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

function normalizeDegree($degree){
  while ($degree < 0){$degree += 360;}
  while ($degree > 360){$degree -= 360;}
  return $degree;
}

function normalizeCoordinates($type, $hemisphere, $value){
  if ($type === "LAT" && $hemisphere === "S"){return $value * -1;}
  if ($type === "LONG" && $hemisphere === "W"){return $value * -1;}
  return $value;
}

function eclipticToEquatorial($longitude, $latitude, $obliquity){
  if ($obliquity == null){$obliquity = 23.4;}
  $equatorial['rightAscention'] = normalizeDegree(rad2deg(atan2(sin(deg2rad($longitude)) * cos(deg2rad($obliquity)) - tan(deg2rad($latitude)) * sin(deg2rad($obliquity)), cos(deg2rad($longitude)))));
  $equatorial['declination'] = normalizeDegree(rad2deg(asin(sin(deg2rad($latitude)) * cos(deg2rad($obliquity)) + cos(deg2rad($latitude))) * sin(deg2rad($obliquity)) * sin(deg2rad($longitude))));
  return $equatorial;
}
?>