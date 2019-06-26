<?php
  function error($msg) {
    header("Location: ../countries.php?error=" . base64_encode($msg));
    exit;
  }

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  if(!isset($_POST["add-iso"]) || !isset($_POST["add-name"]))
    error("Un des champs n'est pas rempli");

  $db = dbConnect();

  $country = new Country();
  $country->setIso_code($_POST["add-iso"]);
  $country->setName($_POST["add-name"]);

  if(!dbAddCountry($db, $country))
    error("Une erreur est survenue durant l'ajour d'un pays. <br /> Ce code iso est probablement deja utilise par un autre pays.");
  else
    header("Location: ../countries.php?info=" . base64_encode("Le pays est maintenant disponible"));
?>
