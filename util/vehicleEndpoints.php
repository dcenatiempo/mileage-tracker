<?php

//////////////////////////
// "DELETE VEHICLE" HANDLER
//////////////////////////
if (isset($_POST['delete-vehicle'])) {
  // TODO: validate info
  $vId = $_POST['id'];

  $deleteStatement = $db->prepare("DELETE FROM public.mileage WHERE vehicleid = ?;");
  $result = $deleteStatement->execute([$vId]);
  // var_dump($result);

  $deleteStatement = $db->prepare("DELETE FROM public.vehicle WHERE id = ?;");
  $result = $deleteStatement->execute([$vId]);
  // var_dump($result);

  if ($result) {
    unset($_SESSION['current-vehicle']);
    header("Location: dashboard.php");
    exit();
  }
}

//////////////////////////
// "ADD NEW VEHICLE" HANDLER
//////////////////////////
if (isset($_POST['add-vehicle'])) {
  // TODO: validate info
  $make = $_POST['make'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $color = $_POST['color'];
  $vin = isset($_POST['vin']) ? $_POST['vin'] : "";
  $preferred = isset($_POST['preferred']) ? 't' : 'f';
  $userId = (int)$_SESSION['userId'];

  // get model id
  $mIdQuery = $db->prepare("SELECT id FROM public.model WHERE make = ? AND model = ? AND year = ?;");
  $mIdQuery->execute([$make, $model, $year]);
  $result = $mIdQuery->fetchAll(PDO::FETCH_NUM);
  $mId = $result[0][0];

  // insert into database
  $vehicleInsert = $db->prepare("INSERT INTO public.vehicle
  (userid, modelid, color, vin, preferred) VALUES
  (?,?,?,?,?)");
  $result = $vehicleInsert->execute([$userId, $mId, $color, $vin, $preferred]);
  if ($result) {

    //preferred
    $vId = intval($db->lastInsertId('vehicle_id_seq'));
    if ($preferred == 't') {
      $statement = $db->prepare(
        "UPDATE public.vehicle
        SET preferred = 'f'
        WHERE userid = ? AND id != ?");
      $result = $statement->execute([$userId, $vId]);
    }
    // current vehicle
    $_SESSION['current-vehicle']['vehicleid'] = $vId;

    header("Location: dashboard.php");
    exit();
  }

  
}

//////////////////////////
// "EDIT VEHICLE" HANDLER
//////////////////////////
if (isset($_POST['edit-vehicle'])) {
  var_dump($_POST);
  // TODO: validate info
  $make = $_POST['make'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $color = $_POST['color'];
  $vin = isset($_POST['vin']) ? $_POST['vin'] : "";
  $preferred = isset($_POST['preferred']) ? 't' : 'f';
  $userId = (int)$_SESSION['userId'];
  $vId = (int)$_SESSION['current-vehicle']['vehicleid'];
  // get model id
  $mIdQuery = $db->prepare("SELECT id FROM public.model WHERE make = ? AND model = ? AND year = ?;");
  $mIdQuery->execute([$make, $model, $year]);
  $result = $mIdQuery->fetchAll(PDO::FETCH_NUM);
  $mId = $result[0][0];

  // insert into database
  $vehicleUpdate = $db->prepare("UPDATE ONLY public.vehicle
  SET (modelid, color, vin, preferred) = (?, ?, ?, ?) WHERE id = ?");
  $result = $vehicleUpdate->execute([$mId, $color, $vin, $preferred, $vId]);

  if ($result) {
    if ($preferred == 't') {
      $statement = $db->prepare(
        "UPDATE public.vehicle
         SET preferred = 'f'
         WHERE userid = ? AND id != ?");
      $result = $statement->execute([$userId, $vId]);
    }
    header("Location: dashboard.php");
    exit();
  }
  //preferred

}
//////////////////////////
// GET VEHICLE LIST
//////////////////////////
$vehicleListQuery = $db->prepare("SELECT v.id AS vehicleid, v.modelid, v.color, v.vin, v.preferred, v.userid, m.year, m.make, m.model FROM public.vehicle v JOIN public.model m ON v.modelid = m.id WHERE v.userid = ?;");
$vehicleListQuery->execute([$_SESSION['userId']]);
$vehicleList = $vehicleListQuery->fetchAll(PDO::FETCH_ASSOC);
// if ($vehicleList != false) {
//   // print_r($vehicleList);
// }

//////////////////////////
// SET CURRENT VEHICLE
//////////////////////////
if (!isset($_SESSION['current-vehicle'])) {
  if (count($vehicleList) == 0) {
    $_SESSION['current-vehicle'] = null;
  }
  else {
    for ($i=0; $i<count($vehicleList); $i++) {
      if ($vehicleList[$i]['preferred'] == 't') {
        $_SESSION['current-vehicle'] = $vehicleList[$i];
        $i = count($vehicleList);
      }
    }
    if (!isset($_SESSION['current-vehicle'])) {
      $_SESSION['current-vehicle'] = $vehicleList[0];
    }
  }
}
else {
  foreach ($vehicleList as $vehicle) {
    if ($vehicle['vehicleid'] == $_SESSION['current-vehicle']['vehicleid']) {
      $_SESSION['current-vehicle'] = $vehicle;
    }
  }
}

//////////////////////////
// CHANGE VEHICLE HANDLER
//////////////////////////
if (isset($_GET['change-vehicle'])) {
  function getPreferred ($item) {
    return $item['vehicleid'] == $_GET['preferred'];
  }

  $temp = array_filter($vehicleList, "getPreferred");
  $key = array_keys($temp)[0];
  $_SESSION['current-vehicle'] = $temp[$key]; 
}