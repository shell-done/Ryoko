<?php
  function error($msg) {
    $_SESSION["info"] = "Erreur:$msg";
    header("Location: ../index.php");
    exit;
  }

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

  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Travel.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/travel_requests.php");

  $db = dbConnect();

  $travel = dbGetTravel($db, $_POST["idTravel"]);

  if(!dbDeleteTravel($db, $_POST["idTravel"]))
    error("Une erreur est survenue lors de la suppression du voyage");
  else {
    $target = $serverRoot . "/" . $travel->getImgDirectory();
    delete_files($target);

    $_SESSION["info"] = "Information:Le voyage a bien été supprimé";
    header("Location: ../index.php");
  }
?>
