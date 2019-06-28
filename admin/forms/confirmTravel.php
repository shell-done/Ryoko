<?php
  //Fonction stockant une erreur et renvoyant sur la page d'origine
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../bookings.php");
    exit;
  }

  session_start();

  //Ajout des fichiers nécessaires 
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Booking.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/booking_requests.php");

  //Vérifie que les variable sont initialisées
  if(!isset($_POST["userEmail"]) || !isset($_POST["travelId"]) || !isset($_POST["status"]))
    error("Un des champs n'est pas renseigné");

  //Vérifie que les variable sont égales a accept et deny
  if($_POST["status"] != "accept" && $_POST["status"] != "deny")
    error("Status invalide");

  //$status est égale à ACCEPTED si le post est égale à accept sinon $status est égale à DENIED
  $status = ($_POST["status"] == "accept" ? "ACCEPTED" : "DENIED");

  $booking = new Booking();
  $booking->setId($_POST["travelId"]);
  $booking->setEmail($_POST["userEmail"]);
  $booking->setValidation($status);

  $db = dbConnect();

  //Vérifie que la validation c'est bien effectué
  if(!dbValidationBooking($db, $booking))
    error("Une erreur est survenue lors du changement de statut de la réservation");

  //par rapport à ce qu'envoie le post, la page affiche seulement les réservations acceptés, refusés ou en attente
  if(isset($_POST["sort"]))
    header("Location: ../bookings.php?mode=" . $_POST["sort"]);
  else
    header("Location: ../bookings.php");
?>
