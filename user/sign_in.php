<?php
    require_once("../php/parts/head.php");
    require_once("../php/processing/sign_in.php");
    $error = (isset($_SESSION["error"]) ? $_SESSION["error"] : "");
    $displayError = ($error === "" ? "none" : "block");
?>

<html>
  <?php generateHead(["sign_in", "footer"]); echo $test;?>

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

              <button onclick="location.href = 'sign_up.php';" class="btn btn-lg btn-primary btn-block text-uppercase" >S'inscrire</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require("parts/footer.html"); ?>
  </body>

</html>
