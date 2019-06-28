<?php
// \file request.php
// Répond aux requêtes ajax du client

// Répond à la requête Ajax
// \param HTTPCode Le code HTTP et le status à renvoyer (ex: 200 OK, 404 Not found)
// \param data Les données à renvoyer
function response($HTTPCode, $data = null) {
    // Header de la requête
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header("HTTP/1.1 $HTTPCode");

    if($data) // On ne renvoie les données que si nécessaire
      echo $data;

    exit;
}

// Transforme un objet php en JSON
// \param obj L'objet php à traduire
// \return Une chaine de caractère correspondant à l'objet traduit en JSON
function objectToJSON($obj) {
  return json_encode($obj->toArray());
}

// Transforme un tableau d'objet php en JSON
// \param obj Le tableau d'objet php à traduire
// \return Une chaine de caractère correspondant aux objets traduit en JSON
function objectsArrayToJSON($arr) {
  $jsonObjects = [];

  foreach($arr as $el)
    array_push($jsonObjects, $el->toArray());

  return json_encode($jsonObjects);
}

// Inclus les fichiers nécessaires
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require("$serverRoot/php/database/database.php");
require("$serverRoot/php/database/country_requests.php");
require("$serverRoot/php/database/travel_requests.php");
require("$serverRoot/php/database/user_requests.php");
require("$serverRoot/php/database/booking_requests.php");

$requestType = $_SERVER['REQUEST_METHOD']; // Récupération du type de requête (GET, POST, PUT ou DELETE)
$request = substr($_SERVER['PATH_INFO'], 1); // Récupère le chemin après le fichier
$request = explode('/', $request); // Récupère les différentes parties de l'URL

$requestRessource = array_shift($request); // On récupère la ressource demandée (null si non spécifiée)
$requestID = array_shift($request); // On récupère l'ID (null si non spécifiée)

$db = dbConnect();

if(!$db)
  response('503 Service Unavailable'); // En cas de problèmes de connexion à la BDD

// Si la ressource demandée est un pays
if($requestRessource == "countries") {
  // GET de la liste des pays
  if($requestType == "GET") {
    $data = dbGetAllCountries($db);

    // Réponse à la requête Ajax en JSON
    response("200 OK", objectsArrayToJSON($data));
  }
}

// Si la ressource demandée est un voyage
else if($requestRessource == "travels") {
  if(!$requestID) { // Si aucun ID n'est spécifié
    if($requestType == "GET") { // Si requête GET
      // On récupère les données de la requêtes et on les prépare pour la demande en BDD
      $country = ($_GET["country"] == "ALL" ? false : $_GET["country"]);
      $duration = ($_GET["duration"] == "ALL" ? false : explode("-", $_GET["duration"]));
      $price = (intval($_GET["price"]) == 5000 ? false : $_GET["price"]);

      // On intialise les durées min et max à false
      $durationMin = false;
      $durationMax = false;
      if(sizeof($duration) == 2) {
        $durationMin = $duration[0];

        if($duration[1] != "Inf") // Si la valeur supérieur est égale à Inf, on ne prend pas en compte la valeur supérieur
          $durationMax = $duration[1];
      }

      // Récupération des informations à la base
      $data = dbGetSelectedTravels($db, $country, $durationMin, $durationMax, $price);

      // Réponse à la requête Ajax en JSON
      response("200 OK", objectsArrayToJSON($data));
    }
  } else { // Si un ID de voyage est définie
    if($requestType == "GET") {
      $data = dbGetTravel($db, $requestID); // On récupère le voyage en question

      $status = dbGetValidationStatus($db, $_GET["userToken"], $requestID); // On récupère le status de la réservation de ce voyage
      $data->setValidationStatus($status);

      // Réponse à la requête Ajax en JSON
      response("200 OK", objectToJSON($data));
    }
  }
}

// Si la ressource demandée est un utilisateur
else if($requestRessource == "user") {
  // GET l'utilisateur
  if($requestType == "GET") {
    if($requestID) { // On identifie l'utilisateur par son token
      $data = dbGetUser($db, $requestID); // On récupère l'utilisateur en question

      // Réponse à la requête Ajax en JSON
      response("200 OK", objectToJSON($data));
    }
  }
}

// Si la ressource demandée est une réservation
else if($requestRessource == "bookings") {
  // Si requête POST
  if($requestType == "POST") {
    // On instancie un objet "Booking" avec les paramètres passés dans la requête
    $booking = new Booking();
    $booking->setToken($_POST["userToken"]);
    $booking->setId($_POST["travelId"]);
    $booking->setDeparture($_POST["departureDate"]);

    // On ajoute la réservation en BDD
    $res = dbAddUserBooking($db, $booking);
    if($res) // Si l'ajout se passe bien, on renvoie 'Created'
      response("201 Created");
  }
  // Si requête GET
  else if($requestType == "GET") {
    // Si l'id de la réservation n'est pas définie, on récupère toutes les réservations
    if(!$requestID) {
      $data = dbGetUserBookedTravels($db, $_GET["userToken"]);
      response("200 OK", objectsArrayToJSON($data));
    } else {
      // Sinon, on renvoie la réservation demandée
      $data = dbGetUserBookedTravel($db, $_GET["userToken"], $requestID);
      response("200 OK", objectToJSON($data));
    }
  }
}

// Si le fichier ne prend pas en compte la requête, on renvoie une erreur 400
response("400 Bad Request");
