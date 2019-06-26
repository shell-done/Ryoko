<?php
  function error($msg) {
    header("Location: ../index.php?error=" . base64_encode($msg));
    exit;
  }

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

    /* Source : https://paulund.co.uk/php-delete-directory-and-files-in-directory */
    if(is_dir($target)){
      $files = glob( $target . '*', GLOB_MARK );

      foreach($files as $file)
        delete_files($file);

      rmdir($target);
    } else if(is_file($target)) {
      unlink($target);
    }
    /* ------------------------------------------ */

    header("Location: ../index.php?info=" . base64_encode("Le voyage n'est maintenant plus disponible"));
  }
?>
