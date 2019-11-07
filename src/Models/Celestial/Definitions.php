<?php

// Create definitions for other classes.

class Definitions {

  // Make the definitions.

  function makeDefinitions(){

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
  }
}

?>
