<?php

//estimates and returns solar RA and DEC as a string
function solarCoordinates($daysSinceEpoch){
  $meanAnomaly = normalizeDegree(357.529 + 0.98560028 * $daysSinceEpoch);
  $meanLongitude = normalizeDegree(280.459 + 0.98564736 * $daysSinceEpoch);
  $gael = normalizeDegree($meanLongitude + 1.915 * sin(deg2rad($meanAnomaly)) + 0.020 * sin(deg2rad(2 * $meanAnomaly))); //geocentric apparent ecliptic longitude
  $meanObliquity = normalizeDegree(23.439 - 0.00000036 * $daysSinceEpoch);

  $Y = cos(deg2rad($meanObliquity)) * sin(deg2rad($gael));
  $X = cos(deg2rad($gael));
  $a = rad2deg(atan($Y / $X));
  if ($X < 0){$sun['rightAscention'] = $a + 180;}
  else if ($Y < 0 && $X > 0){$sun['rightAscention'] = $a + 360;}
  else {$sun['rightAscention'] = $a;}
  $sun['declination'] = rad2deg(asin(sin(deg2rad($meanObliquity)) * sin(deg2rad($gael))));
  return $sun;
}

?>
