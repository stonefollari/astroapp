<?php

// For handling relative conversion such as universal to sidereal time.

class RelativeConverter {
  // Converts universal time to sidereal, using observer position and days since epoch.
  function siderealTime($daysSinceEpoch, $LONG, $UT){
    return  100.46 + 0.985647 * $daysSinceEpoch + $LONG + 15 * $UT;
  }

  // Converts declination and latitude to altitude, using the relative hour angle to the observer.
  function altitude($DEC, $LAT, $HA){
    $DEC = deg2rad($DEC);
    $LAT = deg2rad($LAT);
    $HA = deg2rad($HA);
    return rad2deg(asin(sin($DEC) * sin($LAT) + cos($DEC) * cos($LAT) * cos($HA)));
  }

  // Converts declination and latitude to azimuth, using the relative hour angle to the observer.
  function azimuth($DEC, $LAT, $ALT, $HA){
    $DEC = deg2rad($DEC);
    $LAT = deg2rad($LAT);
    $ALT = deg2rad($ALT);
    $HA = deg2rad($HA);
    $AZ = rad2deg(acos((sin($DEC) - sin($ALT) * sin($LAT)) / (cos($ALT) * cos($LAT))));
    if (sin($HA) > 0) return 360 - $AZ;
    return $AZ;
  }
}

?>
