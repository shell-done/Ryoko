<?php
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../bookings.php");
    exit;
  }

  session_start();

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Booking.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/booking_requests.php");

  if(!isset($_POST["userEmail"]) || !isset($_POST["travelId"]) || !isset($_POST["status"]))
    error("Un des champs n'est pas renseigné");

  if($_POST["status"] != "accept" && $_POST["status"] != "deny")
    error("Status invalide");

  $status = ($_POST["status"] == "accept" ? "ACCEPTED" : "DENIED");

  $booking = new Booking();
  $booking->setId($_POST["travelId"]);
  $booking->setEmail($_POST["userEmail"]);
  $booking->setValidation($status);

  $db = dbConnect();
  if(!dbValidationBooking($db, $booking))
    error("Une erreur est survenue lors du changement de statut de la réservation");

  if(isset($_POST["sort"]))
    header("Location: ../bookings.php?mode=" . $_POST["sort"]);
  else
    header("Location: ../bookings.php");
?>
