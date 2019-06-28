<?php
  // \file editCountry.php
  // Page appelée pour l'édition d'un pays

  //Fonction stockant une erreur et renvoyant sur la page d'origine
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../countries.php");
    exit;
  }

  session_start();

  //Vérification des champs
  if(!isset($_POST["prev-iso"]) || !isset($_POST["new-iso"]) || !isset($_POST["new-name"]))
    error("Un des champs n'est pas renseigné");

  if(strlen(trim($_POST["new-iso"])) < 2 || strlen(trim($_POST["new-iso"])) > 3)
    error("Le code iso doit faire 2 ou 3 caracteres");

  if(strlen(trim($_POST["new-name"])) < 3)
    error("Le nom du pays doit faire au moins 3 caractères");

  //Ajout des fichiers nécessaires
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  $country = new Country();
  $country->setIso_code($_POST["new-iso"]);
  $country->setName($_POST["new-name"]);

  $db = dbConnect();

  //Vérifie que la modification c'est bien effectué
  if(!dbUpdateCountry($db, $country, $_POST["prev-iso"]))
    error("Une erreur est survenue lors de la modification du pays");

  $_SESSION["info"] = "Information:Le pays a bien été modifié";
  header("Location: ../countries.php");
?>
