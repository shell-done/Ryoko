<?php
// \file log_admin.php
// Redirige l'administrateur sur la page de connexion si celui-ci n'est pas connecté

  // Démarre la session
  session_start();

  if(!isset($_SESSION["admin"])) {
    // Si la variable de session n'est pas définie (utilisateur pas connecté), on redirige vers la page de connexion
    header("Location: sign_in.php");
    exit;
  }
?>
