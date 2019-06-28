<?php
  // \file editTravel.php
  // Page appelée pour l'édition d'un voyage

  //Fonction stockant une erreur et renvoyant sur la page d'origine
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../index.php");
    exit;
  }

  session_start();

  //Vérification des champs
  if(!isset($_POST["idTravel"]) || !isset($_POST["title"]) || !isset($_POST["description"]) || !isset($_POST["duration"]) || !isset($_POST["cost"]) || !isset($_POST["country"]))
    error("Un des champs n'est pas spécifié");

  if(strlen(trim($_POST["title"])) < 3)
    error("Le titre doit faire au moins 3 caractères");

  if(strlen(trim($_POST["description"])) < 5)
    error("La description doit faire au moins 5 caractères");

  if(intval(trim($_POST["duration"])) < 1)
    error("La durée doit être un entier strictement positif");

  if(floatval(trim($_POST["cost"])) < 10)
    error("Le prix doit être un nombre supérieur ou égal à 10");

  if(strlen(trim($_POST["country"])) < 2 || strlen(trim($_POST["country"])) > 3)
    error("Le pays n'existe pas");

  //Ajout des fichiers nécessaires
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

  //Vérifie que la modification c'est bien effectué
  if(!dbUpdateTravel($db, $travel))
    error("Une erreur est survenue lors de la modification du voyage");

  $_SESSION["info"] = "Information:Le voyage a bien été modifié";
  header("Location: ../index.php");
?>
