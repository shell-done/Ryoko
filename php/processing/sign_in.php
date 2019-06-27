<?php
  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  unset($_SESSION["error"]);
  if(isset($_POST["login"]) && isset($_POST["password"])) {
    $db = dbConnect();
    $user = dbStartUserSession($db, $_POST["login"], $_POST["password"]);

    if($user == false)
      $_SESSION["error"] = "Adresse email ou mot de passe incorrect";
    else {
      $_SESSION["user"] = serialize($user);
      header("Location: index.php");
      exit;
    }
  }
?>
