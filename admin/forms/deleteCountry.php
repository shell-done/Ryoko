<?php
  function error($msg) {
    header("Location: ../countries.php?error=" . base64_encode($msg));
    exit;
  }

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  if(!isset($_POST["del-iso"]))
    error("Le code iso n'est pas donne");

  $db = dbConnect();

  if(!dbDeleteCountry($db, $_POST["del-iso"]))
    error("Une erreur est survenue durant la suppression d'un pays. Veuillez verifier qu'aucun utilisateur n'est lie a ce pays.");
  else
    header("Location: ../countries.php?info=" . base64_encode("Le voyage n'est maintenant plus disponible"));
?>
