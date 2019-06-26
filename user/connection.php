<?php
    require_once("../php/parts/head.php");
    //require_once("../php/processing/sign-user.php");
    // -> METTRE DANS UN FICHIER A PART ET TRANSPORTER L'ERREUR AVEC SESSION VAR

    require("../php/classes/User.php");
    require("../php/database/database.php");
    require("../php/database/user_requests.php");
    session_start();

    $error = "";
    if(isset($_POST["login"]) && isset($_POST["password"])) {
      $db = dbConnect();
      $user = dbStartUserSession($db, $_POST["login"], $_POST["password"]);

      if($user == false)
        $error = "Adresse email ou mot de passe incorrect";
      else {
        $_SESSION["user"] = serialize($user);
        header("Location: index.php");
        exit;
      }
    }

    $displayError = ($error === "" ? "none" : "block");
?>

<html>
  <?php generateHead(["connection", "footer"]); echo $test;?>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <img src="../img/brand.png" >
              <h5 class="card-title text-center">S'identifier</h5>

              <form class="form-signin" method="post">
                <div class="form-label-group">
                  <input type="email" id="inputEmailSingIn" name="login" class="form-control" placeholder="Email address" required autofocus>
                  <label for="inputEmailSingIn">Adresse mail</label>
                </div>
                <div class="form-label-group">
                  <input type="password" id="inputPasswordSingIn" name="password" class="form-control" placeholder="Password" required>
                  <label for="inputPasswordSingIn">Mot de passe</label>
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Connexion</button>
                <div class="alert alert-danger mt-2" role="alert" style="display: <?=$displayError?>"><?=$error?></div>
              </form>

              <hr class="my-4">

              <button onclick="location.href = 'inscription.php';" class="btn btn-lg btn-primary btn-block text-uppercase" >S'inscrire</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require("parts/footer.html"); ?>
  </body>

</html>
