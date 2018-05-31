<?php

$dbUrl = getenv('DATABASE_URL');
$dbUrl = "postgres://vqmvgjpetvbkfr:6db2b56e64cb6fc32737a410acc91e1e3048689c197a496ec44ae0013b61c112@ec2-23-23-130-158.compute-1.amazonaws.com:5432/d4522ubjgvhe7p";
$dbopts = parse_url($dbUrl);

$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPassword = $dbopts["pass"];
$dbName = ltrim($dbopts["path"],'/');

try
{
  $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}