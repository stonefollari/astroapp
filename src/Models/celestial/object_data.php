<?php

function acquireObjectData($object, $generalData, $observerData){
  $lastObjectNumber = 2;
  $ra = "012-00-26"; //hours-minutes-seconds 000-00-00
  $dec = "000-02-49"; //(sign)dergees-minutes-seconds +00-00-00
  $raBegin_1 = 0;
  $raEnd_1 = 3;
  $raBegin_2 = 4;
  $raEnd_2 = 2;
  $raBegin_3 = 7;
  $raEnd_3 = 2;
  $decSign = 0;

  $moonFixRA = 10;
  $moonFixDEC = 40;

  if ($object[NAME] === "SUN"){
    $ra = $generalData->sunRA;
    $dec = $generalData->sunDEC;
  }
  else if ($object[NAME] === "MOON"){
    $ra = $generalData->moonRA;
    $dec = $generalData->moonDEC;
  }
  else {
    $ra = $object[VALUE];
    $dec = $object[ADDITIONAL];
  }

  $objectData = new stdClass();
  $objectData->name = "OBJECT DATA";
  $objectData->objectName = array("NAME", $object[NAME]);

  $ra = convertToDegrees(null, (float)substr($ra, $raBegin_1, $raEnd_1), (float)substr($ra, $raBegin_2, $raEnd_2), (float)substr($ra, $raBegin_3, $raEnd_3), "+");
  $dec = convertToDegrees((float)substr($dec, $raBegin_1, $raEnd_1), null, (float)substr($dec, $raBegin_2, $raEnd_2), (float)substr($dec, $raBegin_3, $raEnd_3), substr($dec, $decSign, 1));

  $objectData->RA = array("RA", $ra);
  $objectData->DEC = array("DEC", $dec);
  //---------------------MOON_FIX---------------------
  if ($object[NAME] === "MOON"){$objectData->RA[VALUE] = normalizeDegree($objectData->RA[VALUE] + $moonFixRA); $objectData->DEC[VALUE] = normalizeDegree($objectData->DEC[VALUE] + $moonFixDEC);}
  //--------------------------------------------------

  $ha = normalizeDegree($observerData->LST[VALUE] - $objectData->RA[VALUE]);
  $objectData->HA = array("HOUR ANGLE", $ha);

  $alt = altitude($objectData->DEC[VALUE], $observerData->LAT[VALUE], $objectData->HA[VALUE]);
  $objectData->ALT = array("ALTITUDE", $alt);
  $az = azimuth($objectData->DEC[VALUE], $observerData->LAT[VALUE], $objectData->ALT[VALUE], $objectData->HA[VALUE]);
  $objectData->AZ = array("AZIMUTH", $az);
  $objectData->data = array($objectData->objectName, $objectData->RA, $objectData->DEC, $objectData->HA, $objectData->ALT, $objectData->AZ);

  return $objectData;
}

?>
