<?php

/*
  Formats an extended data output to the windows console.
  Only used for testing.
  Author: 56361160991438
*/

class TestOutput {
  /*
    Displays the data in a clear format.
   */ 
  public function displayData($_data, $_line){
    foreach ($_data as $currentData){
    echo "\n", "=======================================", "\n";
      echo $currentData->name, "\n", "_______________________________________", "\n";
      $lineX = 0;
      foreach($currentData->data as $dataField){
        if ($lineX != null && $lineX == $_line){echo "---------------------------------------", "\n";}
        echo $dataField[NAME], ": ", $dataField[VALUE], "\n";
        $lineX++;
      }
    echo "=======================================", "\n";
    }
  }
}

?>
