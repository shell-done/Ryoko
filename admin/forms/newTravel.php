<?php
  function error($msg) {
    header("Location: ../index.php?error=" . base64_encode($msg));
    exit;
  }

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Travel.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/travel_requests.php");

  if(!isset($_POST["add-title"]) && !isset($_POST["add-description"]) && !isset($_POST["add-country"]) && !isset($_POST["add-duration"]))
    error("Un des champs n'a pas été rempli");

  if(strlen(trim($_POST["add-title"])) < 3)
    error("Le titre du voyage doit faire au moins 3 caractères");

  if(strlen(trim($_POST["add-description"])) < 3)
    error("La description du voyage doit faire au moins 3 caractères");

  if(intval($_POST["add-duration"]) < 1)
    error("La durée doit au moins être d'un jour");

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

  if(dbAddTravel($db, $travel))
    error("Une erreur est survenue durant l'ajout d'un voyage");
?>
