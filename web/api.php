<?php
header('Content-type: application/json');

function getModels($db, $make) {
  $modelQuery = $db->query("SELECT DISTINCT model FROM public.model WHERE make = '{$make}' ORDER BY model;");
  $modelQuery->execute();
  $result = $modelQuery->fetchAll(PDO::FETCH_NUM);

  echo json_encode($result);

}

function getYears($db, $make, $model) {
  $yearQuery = $db->query("SELECT DISTINCT year FROM public.model WHERE make = '{$make}' AND model = '{$model}'ORDER BY year;");
  $yearQuery->execute();
  $result = $yearQuery->fetchAll(PDO::FETCH_NUM);

  echo json_encode($result);

}

//////////////////////////
// MAKE/MODEL/YEAR HANDLER
//////////////////////////
if (isset($_GET['make'])) {
  require_once("../util/dbConnect.php");

  if (isset($_GET['model'])) {
      getYears($db, $_GET['make'], $_GET['model']);
  }
  else {
    // Return all models for make
    getModels($db, $_GET['make']);
  }
}
