<?php

if (isset($_SESSION['current-vehicle'])) {
  $metaVehicle = json_encode($_SESSION['current-vehicle']);

  echo "<div vehicle='{$metaVehicle}'>";
  echo "</div>";
}