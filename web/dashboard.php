<?php
require_once(__DIR__ . "/../util/init.php");

if (!isset($_SESSION['userId'])) {
  header("Location: index.php");
  exit();
}

require_once(__DIR__ . "/../util/dbConnect.php");

require_once(__DIR__ . "/../util/mileageEndpoints.php");
require_once(__DIR__ . "/../util/vehicleEndpoints.php");

//////////////////////////
// GET CATEGORY LIST
//////////////////////////
$categoryListQuery = $db->prepare("SELECT id, \"name\" FROM public.category WHERE userid = ?");
$categoryListQuery->execute([$_SESSION['userId']]);
$categoryList = $categoryListQuery->fetchAll(PDO::FETCH_ASSOC);
// var_dump($categoryList);

//////////////////////////
// LOAD MARKUP
////////////////////////////////////////////////////////////////////////////////
require_once(__DIR__ . "/../views/dashboard.php");
////////////////////////////////////////////////////////////////////////////////