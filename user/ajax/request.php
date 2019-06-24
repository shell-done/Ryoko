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

function objectToJSON($obj) {
  return json_encode($obj->toArray());
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
require("$serverRoot/php/database/user_requests.php");
require("$serverRoot/php/database/booking_requests.php");

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
  if(!$requestID) {
    if($requestType == "GET") {
      $country = ($_GET["country"] == "ALL" ? false : $_GET["country"]);
      $duration = ($_GET["duration"] == "ALL" ? false : explode("-", $_GET["duration"]));
      $price = (intval($_GET["price"]) == 5000 ? false : $_GET["price"]);

      $durationMin = false;
      $durationMax = false;
      if(sizeof($duration) == 2) {
        $durationMin = $duration[0];

        if($duration[1] != "Inf")
          $durationMax = $duration[1];
      }

      $data = dbGetSelectedTravels($db, $country, $durationMin, $durationMax, $price);

      response("200 OK", objectsArrayToJSON($data));
    }
  } else {
    if($requestType == "GET") {
      $data = dbGetTravel($db, $requestID);

      $status = dbGetValidationStatus($db, $_GET["userToken"], $requestID);
      $data->setValidationStatus($status);

      response("200 OK", objectToJSON($data));
    }
  }
}

else if($requestRessource == "user") {
  if($requestID) {
    $data = dbGetUser($db, $requestID);
    response("200 OK", objectToJSON($data));
  }
}

else if($requestRessource == "bookings") {
  if($requestType == "POST") {
    $booking = new Booking();
    $booking->setToken($_POST["userToken"]);
    $booking->setId($_POST["travelId"]);
    $booking->setDeparture($_POST["departureDate"]);

    $res = dbAddUserBooking($db, $booking);
    if($res)
      response("201 Created");
  }
  else if($requestType == "GET") {
    if(!$requestID) {
      $data = dbGetUserBookedTravels($db, $_GET["userToken"]);
      response("200 OK", objectsArrayToJSON($data));
    } else {
      $data = dbGetUserBookedTravel($db, $_GET["userToken"], $requestID);
      response("200 OK", objectToJSON($data));
    }
  }
}

response("400 Bad Request");
