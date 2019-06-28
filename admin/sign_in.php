<?php
    // \file sign_in.php
    // Page de connexion pour l'administrateur

    const ADMIN_LOGIN = "admin";
    const ADMIN_PASSWORD = "ryokoAdmin";

    //Ajout des fichiers nécessaires
    require_once("../php/parts/head.php");

    session_start();

    $error = "";

    //Vérifie le mot de passe et le login de l'admin
    //Affiche la page index.php ou une erreur
    if(isset($_POST["submit"])) {
      if($_POST["login"] == ADMIN_LOGIN && $_POST["password"] == ADMIN_PASSWORD) {
        $_SESSION["admin"] = "ok";
        header("Location: index.php");
      } else {
        $error = "Login ou mot de passe incorrect";
      }
    }

    $displayError = ($error === "" ? "none" : "block");
?>

<html>
  <!-- Génere tous les fichiers css nécessaires-->
  <?php generateHead(["sign_in", "footer"]); ?>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <img src="img/brand-admin.png" >
              <h5 class="card-title text-center">Session Administrateur</h5>

              <form class="form-signin" method="post">
                <div class="form-label-group">
                  <input type="text" id="inputEmailSingIn" name="login" class="form-control" placeholder="Email address" required autofocus>
                  <label for="inputEmailSingIn">Identifiant</label>
                </div>
                <div class="form-label-group">
                  <input type="password" id="inputPasswordSingIn" name="password" class="form-control" placeholder="Password" required>
                  <label for="inputPasswordSingIn">Mot de passe</label>
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit">Connexion</button>
                <div class="alert alert-danger mt-2" role="alert" style="display: <?=$displayError?>"><?=$error?></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php /*Affiche le footer */ require("parts/footer.html"); ?>
  </body>

</html>
