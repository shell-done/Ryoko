<?php
  const DEFAULT_USER_EMAIL = "john.smith@webmail.fr";
  const DEFAULT_USER_PWD = "default_password";

  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  if(!isset($_SESSION["user"])) {
    header("Location: sign_in.php");
    exit;
  }

  $db = dbConnect();
  $token = unserialize($_SESSION["user"])->getToken();
  $tokenIsValid = dbCheckToken($db, $token);

  if(!$tokenIsValid) {
    unset($_SESSION["user"]);
    header("Location: sign_in.php");
    exit;
  }
?>
