<?php
// \file log_user.php
// Redirige l'utilisateur sur la page de connexion si celui-ci n'est pas connecté

  //Inclus les fichiers nécessaires
  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  if(!isset($_SESSION["user"])) {
    // Si l'utilisateur n'est pas connecté, on le renvoie sur la page de connexion
    header("Location: sign_in.php");
    exit;
  }

  $db = dbConnect();
  $token = unserialize($_SESSION["user"])->getToken();
  // Si l'utilisateur est connecté, on vérifie que son token est toujours valide
  // Celui-ci pourrait devenir invalide s'il se connecte sur un autre navigateur en même temps
  $tokenIsValid = dbCheckToken($db, $token);

  // Si le token n'est pas valide, on redirige l'utilisateur sur la page de connexion
  if(!$tokenIsValid) {
    unset($_SESSION["user"]);
    header("Location: sign_in.php");
    exit;
  }
?>
