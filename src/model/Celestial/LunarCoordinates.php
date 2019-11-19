<?php

/*
  Estimates and returns current lunar non-relative coordinates as an array.
  Author: 56361160991438
*/

class LunarCoordinates{

  public function getLunarCoordinates($_daysSinceEpoch){
    $converter = new BasicConverter; // Create a new basic converter.

    // Specific estimated values, relevant to the lunar coordinate estimation algorithm.
    $ascendingNode = $converter->normalizeDegree(125.1228 - 0.0529538083 * $_daysSinceEpoch);
    $inclination = 5.1454;
    $perigee = $converter->normalizeDegree(318.0634 + 0.1643573223 * $_daysSinceEpoch);
    $meanDistance = 60.2666;
    $eccentricity = 0.054900;
    $meanAnomaly = $converter->normalizeDegree(115.3654 + 13.0649929509 * $_daysSinceEpoch);

    $eccentricAnomaly_1 = $meanAnomaly + rad2deg($eccentricity * sin(deg2rad($meanAnomaly)) * (1  + $eccentricity * cos(deg2rad($meanAnomaly))));

    $x = $meanDistance * (cos(deg2rad($eccentricAnomaly_1)) - $eccentricity);
    $y = $meanDistance * sqrt(1 - $eccentricity**2) * sin(deg2rad($eccentricAnomaly_1));

    $distance = sqrt($x**2 + $y**2);
    $trueAnomaly = $converter->normalizeDegree(rad2deg(atan2($y, $x)));

    // Estimate the ecliptic-relative three dimensional position of the Moon.
    $xEcliptic = $distance * (cos(deg2rad($ascendingNode)) * cos(deg2rad($trueAnomaly + $perigee)) - sin(deg2rad($ascendingNode)) * sin(deg2rad($trueAnomaly + $perigee)) * cos(deg2rad($inclination)));
    $yEcliptic = $distance * (sin(deg2rad($ascendingNode)) * cos(deg2rad($trueAnomaly + $perigee)) + cos(deg2rad($ascendingNode)) * sin(deg2rad($trueAnomaly + $perigee)) * cos(deg2rad($inclination)));
    $zEcliptic = $distance * sin(deg2rad($trueAnomaly + $perigee)) * sin(deg2rad($inclination));

    // Convert the ecliptic coordinates to equatorial ones.
    $xEquat = $xEcliptic;
    $yEquat = $yEcliptic * cos(deg2rad(23.4406)) - $zEcliptic * sin(deg2rad(23.4406));
    $zEquat = $yEcliptic * sin(deg2rad(23.4406)) + $zEcliptic * cos(deg2rad(23.4406));

    // Convert three dimensional equatorial coordinates to spherical two dimensional right ascension and declination and normalize those.
    $rightAscension = $converter->normalizeDegree(rad2deg(atan2($yEquat, $xEquat)));
    $DEC = $converter->normalizeDegree(rad2deg(atan2($zEquat, sqrt($xEquat**2 + $yEquat**2))));

    $moon['rightAscention'] = $rightAscension;
    $moon['declination'] = $DEC;

    return $moon;
  }

}

?>
