<?php
  //Fonction stockant une erreur et renvoyant sur la page d'origine
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../index.php");
    exit;
  }
  //fonction de suppression des fichiers liés au voyage
  /* Source : https://paulund.co.uk/php-delete-directory-and-files-in-directory */
  function delete_files($target) {
    if(is_dir($target)) {
      $files = glob($target . '*', GLOB_MARK);

        foreach($files as $file) {
          delete_files($file);
        }

        rmdir( $target );
    } else if(is_file($target)) {
        unlink( $target );
    }
  }
  /*--------------------------------------------*/

  session_start();

  if(!isset($_POST["idTravel"]))
    error("L'id du voyage n'existe pas");

  //Ajout des fichiers nécessaires 
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Travel.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/travel_requests.php");

  $db = dbConnect();

  //renvoie les données du voyages
  $travel = dbGetTravel($db, $_POST["idTravel"]);

   //Vérifie que la suppression c'est bien effectué
  if(!dbDeleteTravel($db, $_POST["idTravel"]))
    error("Une erreur est survenue lors de la suppression du voyage");
  else {
    $target = $serverRoot . "/" . $travel->getImgDirectory();
    delete_files($target);

    $_SESSION["info"] = "Information:Le voyage a bien été supprimé";
    header("Location: ../index.php");
  }
?>
