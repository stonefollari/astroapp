<?php

/*
  For handling relative conversion such as universal to sidereal time.
  Traditional scientif names for variables are preserved in order to simplify understanding of algorithms.
  Author: 56361160991438
 */

class RelativeConverter {
  /*
   Converts universal time to sidereal, using observer position and days since epoch.
   */
  public function siderealTime($_daysSinceEpoch, $_LONG, $_UT) {
    // The constants used here are approximations, which are a part of the formula itself.
    return  100.46 + 0.985647 * $_daysSinceEpoch + $_LONG + 15 * $_UT;
  }

  /*
   Converts declination and latitude to altitude, using the relative hour angle to the observer.
   */
  public function altitude($_DEC, $_LAT, $_HA) {
    // Convert all the necessary values to radians.
    $_DEC = deg2rad($_DEC);
    $_LAT = deg2rad($_LAT);
    $_HA = deg2rad($_HA);

    // Calculate and retutn the altitude.
    return rad2deg(asin(sin($_DEC) * sin($_LAT) + cos($_DEC) * cos($_LAT) * cos($_HA)));
  }

  /*
   Converts declination and latitude to azimuth, using the relative hour angle to the observer.
   */
  public function azimuth($_DEC, $_LAT, $_ALT, $_HA) {
    // Convert all the values to radians.
    $_DEC = deg2rad($_DEC);
    $_LAT = deg2rad($_LAT);
    $_ALT = deg2rad($_ALT);
    $_HA = deg2rad($_HA);

    // Calculate the azimuth.
    $_AZ = rad2deg(acos((sin($_DEC) - sin($_ALT) * sin($_LAT)) / (cos($_ALT) * cos($_LAT))));

    // Returns normalized azimuth.
    if (sin($_HA) > 0) {
      return 360 - $_AZ;
    }
    return $_AZ;
  }

  /*
   Convert ecliptic to equatorial observer-specific coordinates.
   */
  public function eclipticToEquatorial($_longitude, $_latitude, $_obliquity) {
     // An estimation of obliquity.
    if ($_obliquity == null) {
      $_obliquity = 23.4;
    }
    $equatorial['rightAscention'] = normalizeDegree(rad2deg(atan2(sin(deg2rad($_longitude)) * cos(deg2rad($_obliquity)) - tan(deg2rad($_latitude)) * sin(deg2rad($_obliquity)), cos(deg2rad($_longitude)))));
    $equatorial['declination'] = normalizeDegree(rad2deg(asin(sin(deg2rad($_latitude)) * cos(deg2rad($_obliquity)) + cos(deg2rad($_latitude))) * sin(deg2rad($_obliquity)) * sin(deg2rad($_longitude))));
    return $equatorial;
  }
}

?>
