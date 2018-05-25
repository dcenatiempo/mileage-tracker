<?php

$makeQuery = $db->query("SELECT DISTINCT make FROM public.model ORDER BY make;");
$makeQuery->execute();
$result = $makeQuery->fetchAll(PDO::FETCH_NUM);

echo "<option value=''>Select Make</option>";

foreach ($result as $row) {
  echo "<option value='{$row[0]}'>{$row[0]}</option>";
}