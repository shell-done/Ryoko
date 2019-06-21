<?php

function response($HTTPCode, $data = null) {
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header("HTTP/1.1 $HTTPCode");

    if($data)
      echo $data;

    exit;
}

function objectsArrayToJSON($arr) {
  $jsonObjects = [];

  foreach($arr as $el)
    array_push($jsonObjects, $el->toArray());

  return json_encode($jsonObjects);
}

$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require("$serverRoot/php/database/database.php");
require("$serverRoot/php/database/country_requests.php");
require("$serverRoot/php/database/travel_requests.php");

$requestType = $_SERVER['REQUEST_METHOD'];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);

$requestRessource = array_shift($request);
$requestID = array_shift($request);

$db = dbConnect();

if(!$db)
  response('503 Service Unavailable');

if($requestRessource == "countries") {
  if($requestType == "GET") {
    $data = dbGetAllCountries($db);
    response("200 OK", objectsArrayToJSON($data));
  }
}

else if($requestRessource == "travels") {
  if($requestType == "GET") {
    $country = ($_GET["country"] == "ALL" ? false : $_GET["country"]);
    $duration = ($_GET["duration"] == "ALL" ? false : explode("-", $_GET["duration"]));
    $price = (intval($_GET["price"]) == 5000 ? false : $_GET["price"]);

    $durationMin = false;
    $durationMax = false;
    if($duration) {
      $durationMin = $duration[0];
      $durationMax = $duration[1];
    }

    $data = dbGetSelectedTravels($db, $country, $durationMin, $durationMax, $price);
    response("200 OK", objectsArrayToJSON($data));
  }
}

response("400 Bad Request");
