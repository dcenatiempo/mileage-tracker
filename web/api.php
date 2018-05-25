<?php

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

if (isset($_GET['make'])) {
  require_once("../util/dbConnect.php");

  if (isset($_GET['model'])) {

    if (isset($_GET['year'])) {
      // Return single id for make, model, year
      // getID($_GET['make'], $_GET['model'], $_GET['year']);
      echo "[]";
    }
    else {
      // Return all years for make and model
      getYears($db, $_GET['make'], $_GET['model']);
    }

  }
  else {
    // Return all models for make
    getModels($db, $_GET['make']);
  }

}



