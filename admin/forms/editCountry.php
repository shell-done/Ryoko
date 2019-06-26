<?php
  function error($msg) {
    header("Location: ../countries.php?error=" . base64_encode($msg));
    exit;
  }

  if(!isset($_POST["prev-iso"]) || !isset($_POST["new-iso"]) || !isset($_POST["new-name"]))
    error("Un des champs n'est pas defini");

  if(trim($_POST["prev-iso"]) == "")
    error("Le code iso est vide");

  if(trim($_POST["new-name"]) == "")
    error("Aucun nom n'est specifie");

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  $country = new Country();
  $country->setIso_code($_POST["new-iso"]);
  $country->setName($_POST["new-name"]);

  $db = dbConnect();

  if(!dbUpdateCountry($db, $country, $_POST["prev-iso"]))
    error("Une erreur est survenue lors de la modification du pays");

  header("Location: ../countries.php?info=" . base64_encode("Le pays est maintenant modifie"));
?>
