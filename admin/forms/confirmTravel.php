<?php
  function error($msg) {
    header("Location: ../bookings.php?error=" . base64_encode($msg));
    exit;
  }

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Booking.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/booking_requests.php");

  if(!isset($_POST["userEmail"]) || !isset($_POST["travelId"]) || !isset($_POST["status"]))
    error("Un des champs n'est pas renseigne");

  if($_POST["status"] != "accept" && $_POST["status"] != "deny")
    error("Status invalide");

  $status = ($_POST["status"] == "accept" ? "ACCEPTED" : "DENIED");

  $booking = new Booking();
  $booking->setId($_POST["travelId"]);
  $booking->setEmail($_POST["userEmail"]);
  $booking->setValidation($status);

  $db = dbConnect();
  if(!dbValidationBooking($db, $booking))
    error("Une erreur est survenue lors du changement de statut de la reservation");

  if(isset($_POST["sort"]))
    header("Location: ../bookings.php?mode=" . $_POST["sort"]);
  else
    header("Location: ../bookings.php");
?>
