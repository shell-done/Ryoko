<?php
  //Fonction stockant une erreur et renvoyant sur la page d'origine
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../countries.php");
    exit;
  }

  session_start();
  
  //Ajout des fichiers nécessaires 
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  //Vérification des champs
  if(!isset($_POST["add-iso"]) || !isset($_POST["add-name"]))
    error("Un des champs n'est pas rempli");

  if(strlen(trim($_POST["add-iso"])) < 2 || strlen(trim($_POST["add-iso"])) > 3)
    error("Le code iso doit faire 2 ou 3 caracteres");

  if(strlen(trim($_POST["add-name"])) < 3)
    error("Le nom du pays doit faire au moins 3 caractères");

  $db = dbConnect();

  //Nouveau pays
  $country = new Country();
  $country->setIso_code($_POST["add-iso"]);
  $country->setName($_POST["add-name"]);

  //Vérifie que l'ajout c'est bien effectué
  if(!dbAddCountry($db, $country))
    error("Une erreur est survenue durant l'ajout d'un pays. <br /> Ce code iso est probablement déjà utilisé par un autre pays.");

  $_SESSION["info"] = "Information:Le pays a bien été ajouté";
  header("Location: ../countries.php");
?>
