<?php
 
if ($vehicleList == null) {
  echo "<h3>You have no vehicles. Please add one below.</h3>";
  echo "<button class='btn add-vehicle'>Add Vehicle</button>";
}
else {
  echo "<button class='btn add-vehicle'>Add Vehicle</button>";
  if (count($vehicleList) > 1) {
    echo "<button class='btn change-vehicle'>Change Vehicle</button>";
  }

  // print_r($_SESSION['current-vehicle']);
  echo "<h2>";
    echo "{$_SESSION['current-vehicle']['year']} {$_SESSION['current-vehicle']['color']} {$_SESSION['current-vehicle']['make']} {$_SESSION['current-vehicle']['model']}";
    echo "<button class='btn edit edit-vehicle'></button>";
    echo "<button class='btn delete delete-vehicle'></button>";
  echo "</h2>";
  echo "<table class='mileage'>";
    echo "<tr>";
      echo "<th>Date</th>";
      echo "<th>Start</th>";
      echo "<th>End</th>";
      echo "<th>Total</th>";
      echo "<th>Category</th>";
      echo "<th></th>";
    echo "</tr>";
    echo "<tr>";
      echo "<td><input date type='date'/></td>";
      echo "<td><input start type='number'/></td>";
      echo "<td><input end type='number'/></td>";
      echo "<td><span  total class='total'></span></td>";
      echo "<td><select category>";
        echo "<option value=''>Select Category</option>";
        foreach ($categoryList as $category) {
          echo "<option value='{$category['id']}'>{$category['name']}</option>";
        }
      echo "</select></td>";
      echo "<td><button disabled class='btn add-mileage'>Add</button></td>";
    echo "</tr>";
    foreach ($mileageList as $mileageItem) {
      echo "<tr>";
        echo "<td>{$mileageItem['date']}</td>";
        echo "<td>{$mileageItem['startmileage']}</td>";
        echo "<td>{$mileageItem['endmileage']}</td>";
        $total = $mileageItem['endmileage'] - $mileageItem['startmileage'];
        echo "<td>{$total}</td>";
        echo "<td>{$mileageItem['category']}</td>";
        echo "<td><button>edit</button></td>";
      echo "</tr>";
    }

  echo "</table>";
}
?>
