<?php
  require_once("php/database/database.php");
  require_once("php/database/travel_requests.php");

  $db = dbConnect();
  //$res = dbGetTravels($db, false, false, false, false);
  $res = dbGetAllTravels($db);

  var_dump($res[0]);
  echo "\n-----\n";
  var_dump(get_object_vars($res[0]));

  //var_dump($res);
?>
