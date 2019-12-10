<?php

/*
  Acquires and stores all the non-realtive object data, through the use of various other objects, which handle specific basic/reltive conversion and estimations.
  Author: 56361160991438
 */

class ObjectData {
  // This values demonstrate the string format of the relative celestial coordinates used at certain stages.
  public $ra = "012-00-26"; // hours-minutes-seconds 000-00-00
  public $dec = "000-02-49"; // (sign)dergees-minutes-seconds +00-00-00

  // For storing the specific positions relevant to various string-encoded data.
  public static $RA_BEGIN_1 = 0;
  public static $RA_END_1 = 3;
  public static $RA_BEGIN_2 = 4;
  public static $RA_END_2 = 2;
  public static $RA_BEGIN_3 = 7;
  public static $RA_END_3 = 2;
  public static $DEC_SIGN = 0;

  // For correcting errors in the lunar non-relative coordinates estimation, due to solar effects.
  public static $MOON_FIX_RA = 10;
  public static $MOON_FIX_DEC = 40;

  /*
     Acquires and stores all the non-realtive object data, through the use of various other objects,
     which handle specific basic/reltive conversion and estimations.
   */
  public function acquireObjectData($_object, $_generalData, $_observerData) {
    // Create a new basic converter object for handing simple conversion, such as degrees to hours.
    $converter = new BasicConverter;
    // Create a new relative converter object for handing observer related conversions.
    $relativeConverter = new RelativeConverter;

    // Solar and lunar coordinates are acquired and stored separately from celestial ones.
    if ($_object[NAME] === "SUN") {
      $ra = $_generalData->sunRA;
      $dec = $_generalData->sunDEC;
    }
    else if ($_object[NAME] === "MOON") {
      $ra = $_generalData->moonRA;
      $dec = $_generalData->moonDEC;
    }
    else {
      $ra = $_object[VALUE];
      $dec = $_object[ADDITIONAL];
    }

    // Name the data container and each individual object within.
    $this->name = "OBJECT DATA";
    $this->objectName = array("NAME", $_object[NAME]);

    $this->CONNECTION = array("CONNECTION", $_object[CONNECTION]);

    // Convert the right ascesion and declination to degrees.
    $ra = $converter->convertToDegrees(null, (float)substr($ra, self::$RA_BEGIN_1, self::$RA_END_1), (float)substr($ra, self::$RA_BEGIN_2, self::$RA_END_2), (float)substr($ra, self::$RA_BEGIN_3, self::$RA_END_3), "+");
    $dec = $converter->convertToDegrees((float)substr($dec, self::$RA_BEGIN_1 + 1, self::$RA_END_1 - 1), null, (float)substr($dec, self::$RA_BEGIN_2, self::$RA_END_2), (float)substr($dec, self::$RA_BEGIN_3, self::$RA_END_3), substr($dec, self::$DEC_SIGN, 1));

    if ($_object[NAME] === "MOON") {
      $dec = $converter->convertToDegrees((float)substr($dec, self::$RA_BEGIN_1, self::$RA_END_1), null, (float)substr($dec, self::$RA_BEGIN_2, self::$RA_END_2), (float)substr($dec, self::$RA_BEGIN_3, self::$RA_END_3), substr($dec, self::$DEC_SIGN, 1));
    }

    // Store the converted right ascesion and declination.
    $this->RA = array("RA", $ra);
    $this->DEC = array("DEC", $dec);

    // A very simple fix for the moon's position.
    if ($_object[NAME] === "MOON") {
      $this->RA[VALUE] = $converter->normalizeDegree($this->RA[VALUE] + self::$MOON_FIX_RA);
      $this->DEC[VALUE] = $converter->normalizeDegree($this->DEC[VALUE] + self::$MOON_FIX_DEC);
    }

    // Acquire (through right ascesin and local sidereal time) and convert and store the hour angle.
    $ha = $converter->normalizeDegree($_observerData->LST[VALUE] - $this->RA[VALUE]);
    $this->HA = array("HOUR ANGLE", $ha);

    // Convert non-relative to relative coordinates and store them.
    $alt = $relativeConverter->altitude($this->DEC[VALUE], $_observerData->latitude[VALUE], $this->HA[VALUE]);
    $this->ALT = array("ALTITUDE", $alt);
    $az = $relativeConverter->azimuth($this->DEC[VALUE], $_observerData->latitude[VALUE], $this->ALT[VALUE], $this->HA[VALUE]);
    $this->AZ = array("AZIMUTH", $az);
    $this->data = array($this->objectName, $this->RA, $this->DEC, $this->HA, $this->ALT, $this->AZ);
  }
}

?>
