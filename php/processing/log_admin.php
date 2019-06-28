<?php
  session_start();

  if(!isset($_SESSION["admin"])) {
    header("Location: sign_in.php");
    exit;
  }
?>
