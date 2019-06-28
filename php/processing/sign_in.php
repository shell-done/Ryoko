<?php
// \file sign_in.php
// Permet l'authentification de l'utilisateur

  // Inclus les fichiers nécessaires
  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  unset($_SESSION["error"]);

  //On vérifie que le login et le mot de passe sont bien définis
  if(isset($_POST["login"]) && isset($_POST["password"])) {
    $db = dbConnect();
    // On récupère l'utilisateur correspondant (ou false en cas d'erreur)
    $user = dbStartUserSession($db, $_POST["login"], $_POST["password"]);

    // Si l'utilisateur n'existe pas, on stock une erreur, sinon on stock l'utilisateur en session et on le redirige vers la page index
    if($user == false)
      $_SESSION["error"] = "Adresse email ou mot de passe incorrect";
    else {
      $_SESSION["user"] = serialize($user);
      header("Location: index.php");
      exit;
    }
  }
?>
