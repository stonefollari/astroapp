<?php

function siderealTime($daysSinceEpoch, $LONG, $UT){
  return  100.46 + 0.985647 * $daysSinceEpoch + $LONG + 15 * $UT;
}

function altitude($DEC, $LAT, $HA){
  $DEC = deg2rad($DEC);
  $LAT = deg2rad($LAT);
  $HA = deg2rad($HA);
  return rad2deg(asin(sin($DEC) * sin($LAT) + cos($DEC) * cos($LAT) * cos($HA)));
}

function azimuth($DEC, $LAT, $ALT, $HA){
  $DEC = deg2rad($DEC);
  $LAT = deg2rad($LAT);
  $ALT = deg2rad($ALT);
  $HA = deg2rad($HA);
  $AZ = rad2deg(acos((sin($DEC) - sin($ALT) * sin($LAT)) / (cos($ALT) * cos($LAT))));
  if (sin($HA) > 0) return 360 - $AZ;
  return $AZ;
}

?>
