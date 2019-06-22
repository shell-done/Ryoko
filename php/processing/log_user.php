<?php
  const DEFAULT_USER_EMAIL = "john.smith@webmail.fr";
  const DEFAULT_USER_PWD = "default_password";

  require("../php/classes/User.php");
  require("../php/database/database.php");
  require("../php/database/user_requests.php");
  session_start();

  if(!isset($_SESSION["user"]) || 1) {
    $db = dbConnect();
    $user = dbStartUserSession($db, DEFAULT_USER_EMAIL, DEFAULT_USER_PWD);

    if($user == false)
      $_SESSION["user"] = false;
    else
      $_SESSION["user"] = serialize($user);
  }
?>
