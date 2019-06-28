<?php
  session_start();

  //Détruit la varible de session et renvoie vers la page sing-in.php
  
  if(isset($_SESSION["admin"]))
    unset($_SESSION["admin"]);

  header("Location: ../sign_in.php");
?>
