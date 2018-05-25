<?php
require_once(__DIR__ . "/../util/init.php");
require_once(__DIR__ . "/../util/dbConnect.php");

if (!isset($_SESSION['userId'])) {
  header("Location: index.php");
  exit();
}

//////////////////////////
// ADD NEW VEHICLE HANDLER
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
  $mIdQuery = $db->query("SELECT id FROM public.model WHERE make = '{$make}' AND model = '{$model}' AND year = '{$year}';");
  $mIdQuery->execute();
  $result = $mIdQuery->fetchAll(PDO::FETCH_NUM);
  $mId = $result[0][0];

  // insert into database
  $vehicleInsert = $db->prepare("INSERT INTO public.vehicle
  (userid, modelid, color, vin, preferred) VALUES
  (?,?,?,?,?)");
  $result = $vehicleInsert->execute(array($userId, $mId, $color, $vin, $preferred));

  //preferred
  $vId = intval($db->lastInsertId('vehicle_id_seq'));
  if ($preferred == 't') {
    $statement = $db->prepare(
      "UPDATE public.vehicle
       SET preferred = 'f'
       WHERE userid = ? AND id != ?");
    $result = $statement->execute(array($userId, $vId));
  }
}

//////////////////////////
// GET VEHICLE LIST
//////////////////////////
$vehicleListQuery = $db->query("SELECT v.id AS vehicleid, v.modelid, v.color, v.vin, v.preferred, v.userid, m.year, m.make, m.model FROM public.vehicle v JOIN public.model m ON v.modelid = m.id WHERE v.userid = '{$_SESSION['userId']}';");
$vehicleListQuery->execute();
$vehicleList = $vehicleListQuery->fetchAll(PDO::FETCH_ASSOC);
// if ($vehicleList != false) {
//   // print_r($vehicleList);
// }

//////////////////////////
// CHANGE VEHICLE HANDLER
//////////////////////////
if (isset($_POST['change-vehicle'])) {
  function getPreferred ($item) {
    return $item['vehicleid'] == $_POST['preferred'];
  }

  $temp = array_filter($vehicleList, "getPreferred");
  $key = array_keys($temp)[0];
  $_SESSION['current-vehicle'] = $temp[$key]; 
}

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

//////////////////////////
// GET MILEAGE LIST
//////////////////////////
$mileageListQuery = $db->prepare("SELECT m.date, m.startmileage, m.endmileage, c.name as category FROM public.mileage m JOIN public.category c ON m.categoryid = c.id WHERE vehicleid = ?");
$mileageListQuery->execute(array($_SESSION['current-vehicle']['vehicleid']));
$mileageList = $mileageListQuery->fetchAll(PDO::FETCH_ASSOC);
var_dump($mileageList);


//////////////////////////
// GET CATEGORY LIST
//////////////////////////
$categoryListQuery = $db->prepare("SELECT id, \"name\" FROM public.category WHERE userid = ?");
$categoryListQuery->execute(array($_SESSION['userId']));
$categoryList = $categoryListQuery->fetchAll(PDO::FETCH_ASSOC);
// var_dump($categoryList);

//////////////////////////
// LOAD MARKUP
////////////////////////////////////////////////////////////////////////////////
require_once(__DIR__ . "/../views/dashboard.php");
////////////////////////////////////////////////////////////////////////////////