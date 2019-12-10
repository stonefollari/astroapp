<?php

/*
  Create definitions for other classes.
  Some definitions are left inside their own classes, generally those that deal with string analysis,
  and therefore might be subject to repeated change.
  Author: 56361160991438
 */

class Definitions {

  /*
    Makes the required definitions.
   */
  public function makeDefinitions() {

    // Specify locations of data inside the array for the Coordinates class.
    define("NAME", 0);
    define("VALUE", 1);
    define("ADDITIONAL", 2);
    define("CONNECTION", 3);

    // Specify the data requests for the Data Receiver class.
    define("ASTRONOMY", 0);
    define("NAMES_AND_CONNECTIONS", 1);
    define("WORLD_TIME", 2);

    define("STAR_NAMES", 0);
    define("STAR_CONNECTIONS", 1);

    // Specify the celetial data offset, to account for the Sun and the Moon for the Celestial Coordinates class.
    define("CELESTIAL_DATA_OFFSET", 2);

    // Specify the position where the data begins (on each line) for the Celestial Coordinates class.
    define("DATA_BEGIN", 3);

    // For the basic converter tester, map function names to numbers, defining where the required data is stored.
    define("TIME_TO_DECIMAL", 0);
    define("HOURS_TO_DEGREES", 1);
    define("DEGREES_TO_HOURS", 2);
    define("NORMALIZE_DEGREES", 3);
    define("NORMALIZE_COORDINATES", 4);

    // For the basic converter tester, specifiy that values are parameters to a function.
    define("FIRST_PARAMETER", 0);
    define("SECOND_PARAMETER", 1);
    define("THIRD_PARAMETER", 2);
    define("FOURTH_PARAMETER", 3);
    define("FIFTH_PARAMETER", 4);
  }
}

?>
