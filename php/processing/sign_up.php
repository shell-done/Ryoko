<?php
// \file sign_in.php
// Permet l'inscription de l'utilisateur

  // Inclus les fichiers nécessaires
  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  unset($_SESSION["error"]);
  $error = "";

  // On vérifie que tous les champs sont bien définis, sinon on génère une erreur
  if(isset($_POST["submit"])) {
    if(isset($_POST["inputName"]) && isset($_POST["inputFirstname"]) && isset($_POST["inputBirthdate"]) && isset($_POST["inputEmail"])
      && isset($_POST["inputPassword"]) && isset($_POST["inputPasswordConfirm"]) && isset($_POST["inputAddress"]) && isset($_POST["inputZipCode"])
      && isset($_POST["inputCity"]) && isset($_POST["inputCountry"]) && isset($_POST["inputTel"])) {

      if(strlen(trim($_POST["inputName"])) < 3)
        $error = "Le nom doit faire au minimum 3 caractères";

      if(strlen(trim($_POST["inputFirstname"])) < 3)
        $error = "Le prénom doit faire au minimum 3 caractères";

      if(strtotime($_POST["inputBirthdate"]) === false)
        $error = "La date de naissance est invalide";

      if(strlen(trim($_POST["inputEmail"])) < 5)
        $error = "L'adresse email doit faire au minimum 5 caractères";

      if(strlen(trim($_POST["inputAddress"])) < 8)
        $error = "L'adresse doit faire au minimum 8 caractères";

      if(strlen($_POST["inputPassword"]) < 5)
        $error = "Le mot de passe doit faire au minimum 5 caractères";

      if($_POST["inputPassword"] !== $_POST["inputPasswordConfirm"])
        $error = "Les mots de passe ne correspondent pas";

      if(strlen(trim($_POST["inputZipCode"])) != 5)
        $error = "Le code postal doit faire exactement 5 caractères";

      if(strlen(trim($_POST["inputCity"])) < 2)
        $error = "La ville doit faire au minimum 2 caractères";

      if(strlen(trim($_POST["inputTel"])) < 5 || strlen(trim($_POST["inputTel"])) > 10)
        $error = "Le numéro de téléphone doit comprendre entre 5 et 10 chiffres";

      // Si aucune erreur n'est présente, on créer un objet 'User'
      if($error === "") {
        $user = new User();
        $user->setEmail($_POST["inputEmail"]);
        $user->setPassword($_POST["inputPassword"]);
        $user->setName($_POST["inputName"]);
        $user->setFirstName($_POST["inputFirstname"]);
        $user->setPhone($_POST["inputTel"]);
        $user->setCity($_POST["inputCity"]);
        $user->setZipCode($_POST["inputZipCode"]);
        $user->setStreet($_POST["inputAddress"]);
        $user->setBirthDate($_POST["inputBirthdate"]);
        $user->setCountry($_POST["inputCountry"]);

        $db = dbConnect();
        if(dbAddUser($db, $user)) { // On ajoute l'utilisateur en base
          // Si l'ajout se passe bien, on récupère l'utilisateur ajouté
          $user = dbStartUserSession($db, $_POST["inputEmail"], $_POST["inputPassword"]);

          // On met l'utilisateur dans la variable de session
          if($user) {
            $_SESSION["user"] = serialize($user);
            header("Location: index.php");
          } else {
            $error = "Erreur lors de la récupération du compte";
          }
        } else {
          $error = "Erreur lors de la création du compte";
        }
      }
    } else {
      $error = "Un des champs est vide";
    }
  }

  // En cas d'erreur, on stock celle-ci dans la variable de session
  if($error !== "")
    $_SESSION["error"] = $error;
?>
