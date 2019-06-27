<?php
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../countries.php");
    exit;
  }

  session_start();

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  if(!isset($_POST["del-iso"]))
    error("Le code iso n'est pas donné");

  $db = dbConnect();

  if(!dbDeleteCountry($db, $_POST["del-iso"]))
    error("Une erreur est survenue durant la suppression d'un pays. Veuillez vérifier qu'aucun utilisateur n'est lié a ce pays.");

  $_SESSION["info"] = "Information:Le pays a bien été supprimé";
  header("Location: ../countries.php");
?>
