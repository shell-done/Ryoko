<?php
  // \file sign_out.php
  // Page appelée pour la déconnexion de l'admin

  session_start();

  //Détruit la varible de session et renvoie vers la page sing_in.php
  if(isset($_SESSION["admin"]))
    unset($_SESSION["admin"]);

  header("Location: ../sign_in.php");
?>
