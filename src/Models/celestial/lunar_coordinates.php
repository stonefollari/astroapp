<?php

//estimates and returns lunar coordinates as a string
function lunarCoordinates($DAYS_SINCE_EPOCH){
  $ascendingNode = normalizeDegree(125.1228 - 0.0529538083 * $DAYS_SINCE_EPOCH);
  $inclination = 5.1454;
  $perigee = normalizeDegree(318.0634 + 0.1643573223 * $DAYS_SINCE_EPOCH);
  $meanDistance = 60.2666;
  $eccentricity = 0.054900;
  $meanAnomaly = normalizeDegree(115.3654 + 13.0649929509 * $DAYS_SINCE_EPOCH);

  $eccentricAnomaly_1 = $meanAnomaly + rad2deg($eccentricity * sin(deg2rad($meanAnomaly)) * (1  + $eccentricity * cos(deg2rad($meanAnomaly))));

  $x = $meanDistance * (cos(deg2rad($eccentricAnomaly_1)) - $eccentricity);
  $y = $meanDistance * sqrt(1 - $eccentricity**2) * sin(deg2rad($eccentricAnomaly_1));

  $distance = sqrt($x**2 + $y**2);
  $trueAnomaly = normalizeDegree(rad2deg(atan2($y, $x)));

  $xEcliptic = $distance * (cos(deg2rad($ascendingNode)) * cos(deg2rad($trueAnomaly + $perigee)) - sin(deg2rad($ascendingNode)) * sin(deg2rad($trueAnomaly + $perigee)) * cos(deg2rad($inclination)));
  $yEcliptic = $distance * (sin(deg2rad($ascendingNode)) * cos(deg2rad($trueAnomaly + $perigee)) + cos(deg2rad($ascendingNode)) * sin(deg2rad($trueAnomaly + $perigee)) * cos(deg2rad($inclination)));
  $zEcliptic = $distance * sin(deg2rad($trueAnomaly + $perigee)) * sin(deg2rad($inclination));

  $xEquat = $xEcliptic;
  $yEquat = $yEcliptic * cos(deg2rad(23.4406)) - $zEcliptic * sin(deg2rad(23.4406));
  $zEquat = $yEcliptic * sin(deg2rad(23.4406)) + $zEcliptic * cos(deg2rad(23.4406));

  $RA = normalizeDegree(rad2deg(atan2($yEquat, $xEquat)));
  $DEC = normalizeDegree(rad2deg(atan2($zEquat, sqrt($xEquat**2 + $yEquat**2))));

  $moon['rightAscention'] = $RA;
  $moon['declination'] = $DEC;

  return $moon;
}

?>
