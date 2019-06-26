<?php
  function error($msg) {
    header("Location: ../index.php?error=" . base64_encode($msg));
    exit;
  }

  if(!isset($_POST["idTravel"]))
    error("L'id du voyage n'existe pas");

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Travel.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/travel_requests.php");

  $travel = new Travel();
  $travel->setId($_POST["idTravel"]);
  $travel->setTitle($_POST["title"]);
  $travel->setDescription($_POST["description"]);
  $travel->setDuration($_POST["duration"]);
  $travel->setCost($_POST["cost"]);
  $travel->setCountry($_POST["country"]);

  $db = dbConnect();

  if(!dbUpdateTravel($db, $travel))
    error("Une erreur est survenue lors de la modification du voyage");

  header("Location: ../index.php?info=" . base64_encode("Le voyage est maintenant modifie"));
?>
