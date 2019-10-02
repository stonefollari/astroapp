<?php

//output for testing
function displayData($data, $line){
  foreach ($data as $currentData){
  echo "\n", "=======================================", "\n";
    echo $currentData->name, "\n", "_______________________________________", "\n";
    $lineX = 0;
    foreach($currentData->data as $dataField){
      if ($lineX != null && $lineX == $line){echo "---------------------------------------", "\n";}
      echo $dataField[NAME], ": ", $dataField[VALUE], "\n";
      $lineX++;
    }
  echo "=======================================", "\n";
  }
}

?>
