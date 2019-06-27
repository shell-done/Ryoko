<?php
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../index.php");
    exit;
  }

  session_start();

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Travel.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/travel_requests.php");

  if(!isset($_POST["add-title"]) || !isset($_POST["add-description"]) || !isset($_POST["add-country"]) || !isset($_POST["add-duration"]) || !isset($_POST["add-price"]))
    error("Un des champs n'est pas rempli");

  if(strlen(trim($_POST["add-title"])) < 3)
    error("Le titre doit faire au moins 3 caractères");

  if(strlen(trim($_POST["add-description"])) < 5)
    error("La description doit faire au moins 5 caractères");

  if(intval(trim($_POST["add-duration"])) < 1)
    error("La durée doit être un entier strictement positif");

  if(intval(trim($_POST["add-cost"])) < 10)
    error("Le prix doit être un entier strictement positif");

  if(strlen(trim($_POST["add-country"])) < 2 || strlen(trim($_POST["country"])) > 3)
    error("Le pays n'existe pas");


  $imgDir = "travels/" . substr(hash("sha256", uniqid("", true)), 0, 16) . "/";
  mkdir($serverRoot . "/" . $imgDir);

  if(isset($_FILES["add-file"])) {
    $total = count($_FILES['add-file']['name']);
    for($i=0; $i<$total; $i++) {
      $tmpFilePath = $_FILES['add-file']['tmp_name'][$i];

      if($tmpFilePath != ""){
        $newFilePath = $serverRoot . "/" . $imgDir . $_FILES['add-file']['name'][$i];
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }

  $travel = new Travel();
  $travel->setTitle($_POST["add-title"]);
  $travel->setDescription($_POST["add-description"]);
  $travel->setDuration($_POST["add-duration"]);
  $travel->setCountry($_POST["add-country"]);
  $travel->setCost($_POST["add-price"]);
  $travel->setImgDirectory($imgDir);

  $db = dbConnect();

  if(!dbAddTravel($db, $travel))
    error("Une erreur est survenue durant l'ajout d'un voyage");

  $_SESSION["info"] = "Information:Le voyage a bien été ajouté";
  header("Location: ../index.php");
?>
