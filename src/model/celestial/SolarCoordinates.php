<?php

/*
  Estimates and returns the current solar non-relative coordinates as an array.
  Author: 56361160991438
*/

class SolarCoordinates {
  public function getSolarCoordinates($_daysSinceEpoch){
    $converter = new BasicConverter;

    // Various esrimation specific to solar position relative to the planet.
    $meanAnomaly = $converter->normalizeDegree(357.529 + 0.98560028 * $_daysSinceEpoch);
    $meanLongitude = $converter->normalizeDegree(280.459 + 0.98564736 * $_daysSinceEpoch);
    $gael = $converter->normalizeDegree($meanLongitude + 1.915 * sin(deg2rad($meanAnomaly)) + 0.020 * sin(deg2rad(2 * $meanAnomaly))); //geocentric apparent ecliptic longitude
    $meanObliquity = $converter->normalizeDegree(23.439 - 0.00000036 * $_daysSinceEpoch);

    // Acquire the solar right ascesion and declination.
    $Y = cos(deg2rad($meanObliquity)) * sin(deg2rad($gael));
    $X = cos(deg2rad($gael));
    $a = rad2deg(atan($Y / $X));
    if ($X < 0){$sun['rightAscention'] = $a + 180;}
    else if ($Y < 0 && $X > 0){$sun['rightAscention'] = $a + 360;}
    else {$sun['rightAscention'] = $a;}
    $sun['declination'] = rad2deg(asin(sin(deg2rad($meanObliquity)) * sin(deg2rad($gael))));
    return $sun;
  }
}

?>
