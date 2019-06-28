<?php
  session_start();

  if(isset($_SESSION["admin"]))
    unset($_SESSION["admin"]);

  header("Location: ../sign_in.php");
?>
