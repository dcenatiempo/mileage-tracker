<?php

//////////////////////////
// "ADD NEW MILEAGE" HANDLER
//////////////////////////
if (isset($_GET['add-mileage'])) {
  //TODO: Validate input
  $date = $_GET['date'];
  $start = $_GET['start'];
  $end = $_GET['end'];
  $categoryId = $_GET['category'];

  // insert into database
  $mileageInsert = $db->prepare("INSERT INTO public.mileage
  (\"date\", startmileage, endmileage, vehicleid, categoryid) VALUES
  (?,?,?,?,?)");
  $result = $mileageInsert->execute([$date, $start, $end, $_SESSION['current-vehicle']['vehicleid'], $categoryId]);
  if ($result) {
    header("Location: dashboard.php");
    exit();
  }
  else {
    echo "failure!";
  }
}

//////////////////////////
// GET MILEAGE LIST
//////////////////////////
$mileageListQuery = $db->prepare("SELECT m.date, m.startmileage, m.endmileage, c.name as category FROM public.mileage m JOIN public.category c ON m.categoryid = c.id WHERE vehicleid = ?");
$mileageListQuery->execute([$_SESSION['current-vehicle']['vehicleid']]);
$mileageList = $mileageListQuery->fetchAll(PDO::FETCH_ASSOC);
// var_dump($mileageList);