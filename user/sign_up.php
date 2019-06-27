<?php
require_once("../php/parts/head.php");
require_once("../php/processing/sign_up.php");
$error = (isset($_SESSION["error"]) ? $_SESSION["error"] : "");
$displayError = ($error === "" ? "none" : "block");
?>


<html>
  <?php generateHead(["sign_in", "footer"]);?>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">S'inscrire</h5>
              <form class="form-signin" method="post">
                <div class="form-label-group">
                  <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Name" required autofocus>
                  <label for="inputName">Nom</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputFirstname" name="inputFirstname" class="form-control" placeholder="Firstname" required>
                  <label for="inputFirstname">Prénom</label>
                </div>
                <div class="form-label-group">
                  <input type="date" id="inputBirthdate" name="inputBirthdate" class="form-control"  placeholder="Birthdate" required max= <?php echo date('Y-m-d');?>>
                  <label for="inputBirthdate">Date de naissance</label>
                </div>
                <div class="form-label-group">
                  <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                  <label for="inputEmail">Adresse mail</label>
                </div>
                <div class="form-label-group">
                  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Mot de passe</label>
                </div>
                <div class="form-label-group">
                  <input type="password" id="inputPasswordConfirm" name="inputPasswordConfirm" class="form-control" placeholder="Password" required>
                  <label for="inputPasswordConfirm">Confirmation du mot de passe</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputAddress" name="inputAddress" class="form-control" placeholder="Address" required autofocus>
                  <label for="inputAddress">Adresse </label>
                </div>

                <div class="form-label-group">
                  <input type="text"  pattern="[0-9]{5}" maxlength ="5" id="inputZipCode" name="inputZipCode" class="form-control" placeholder="ZipCode" required>
                  <label for="inputZipCode">Code postal</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputCity" name="inputCity" class="form-control" placeholder="City" required>
                  <label for="inputCity">Ville</label>
                </div>
                <div class="form-group">
                  <select id="inputCountry" name="inputCountry" class="form-control" style="height: auto; border-radius: 2rem; padding: var(--input-padding-y) var(--input-padding-x)" required>
                    <option value="FR">France</option>
                  </select>
                </div>
                <div class="form-label-group">
                  <input type="tel" id="inputTel" name="inputTel" maxlength ="10"class="form-control" placeholder="Password" required>
                  <label for="inputTel">Numéro de téléphone</label>
                </div>

                <input type="hidden" name="register" value="">
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit">S'enregistrer</button>
                <div class="alert alert-danger mt-2" role="alert" style="display: <?=$displayError?>"><?=$error?></div>
              </form>

              <hr class="my-4">

              <button onclick="location.href = 'sign_in.php';" class="btn btn-lg btn-primary btn-block text-uppercase" >Se connecter</button>

            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require("parts/info-popup.html"); ?>
    <?php require("parts/footer.html"); ?>
  </body>

  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/sign_up.js" defer></script>
</html>
