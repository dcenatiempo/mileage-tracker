<?php
foreach ($vehicleList as $vehicle) {
  echo "<span>";
    echo "<input type='radio' id='vid-{$vehicle['vehicleid']}' name='preferred' value='{$vehicle['vehicleid']}'";
    if ($_SESSION['current-vehicle']['vehicleid'] == $vehicle['vehicleid']) {
      echo " checked";
    }
    echo ">";
    echo "<label for='vid-{$vehicle['vehicleid']}'>{$vehicle['year']} {$vehicle['color']} {$vehicle['make']} {$vehicle['model']}</label>";
  echo "</span>";
}

