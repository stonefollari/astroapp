<?php

/*
  For handling relative conversion such as universal to sidereal time.
  Author: 56361160991438
*/

class RelativeConverter {
  // Converts universal time to sidereal, using observer position and days since epoch.
  public function siderealTime($_daysSinceEpoch, $_LONG, $_UT){
    return  100.46 + 0.985647 * $_daysSinceEpoch + $_LONG + 15 * $_UT;
  }

  // Converts declination and latitude to altitude, using the relative hour angle to the observer.
  public function altitude($_DEC, $_LAT, $_HA){
    $_DEC = deg2rad($_DEC);
    $_LAT = deg2rad($_LAT);
    $_HA = deg2rad($_HA);
    return rad2deg(asin(sin($_DEC) * sin($_LAT) + cos($_DEC) * cos($_LAT) * cos($_HA)));
  }

  // Converts declination and latitude to azimuth, using the relative hour angle to the observer.
  public function azimuth($_DEC, $_LAT, $_ALT, $_HA){
    $_DEC = deg2rad($_DEC);
    $_LAT = deg2rad($_LAT);
    $_ALT = deg2rad($_ALT);
    $_HA = deg2rad($_HA);
    $_AZ = rad2deg(acos((sin($_DEC) - sin($_ALT) * sin($_LAT)) / (cos($_ALT) * cos($_LAT))));
    if (sin($_HA) > 0){
      return 360 - $_AZ;
    }
    return $_AZ;
  }

  // Convert ecliptic to equatorial observer-specific coordinates.
  public function eclipticToEquatorial($_longitude, $_latitude, $_obliquity){
    if ($_obliquity == null){$_obliquity = 23.4;} //an estimation of obliquity.
    $equatorial['rightAscention'] = normalizeDegree(rad2deg(atan2(sin(deg2rad($_longitude)) * cos(deg2rad($_obliquity)) - tan(deg2rad($_latitude)) * sin(deg2rad($_obliquity)), cos(deg2rad($_longitude)))));
    $equatorial['declination'] = normalizeDegree(rad2deg(asin(sin(deg2rad($_latitude)) * cos(deg2rad($_obliquity)) + cos(deg2rad($_latitude))) * sin(deg2rad($_obliquity)) * sin(deg2rad($_longitude))));
    return $equatorial;
  }
}

?>
