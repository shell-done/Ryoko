<?php
  //Ajout des fichiers nécessaires 
  require_once("../php/processing/log_admin.php");
  require_once("../php/parts/head.php");
  require_once("../php/processing/utilities.php");
  require_once("../php/processing/countries-admin.php");
?>

<html>
  <!-- Génere tous les fichiers css nécessaires-->
  <?php generateHead(["index", "navbar", "header", "countries", "footer"]);?>

  <body>

    <?php /*Affiche la navbar admin */ require("parts/navbar.html"); ?>
    <?php /*Affiche le header */ require("parts/header.html"); ?>

    <div class="position-relative">
        <form class="add-country-bar" method="post" action="forms/newCountry.php">
            <h2>Ajouter</h2>
            <div id="box1">
                <div class="form-elements">
                    <label for="add-iso">ISO Code</label>
                    <input type="text" id="add-iso" name="add-iso" maxlength="3">
                </div>
            </div>
            <div id="box2">
                <div class="form-elements">
                    <label for="add-name">Pays</label>
                    <input type="text" id="add-name" name="add-name" maxlength="64">
                </div>
                <div class="form-elements" style="float: right;">
                    <button type="submit">Ajouter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="results-box">
            <h2>Pays enregistrés</h2>
            <div class="alert alert-secondary" role="alert">
              <h4 class="alert-heading">Attention :</h4>
              <p>
                Il n'est pas possible de supprimer un pays associé à l'adresse d'un utilisateur. <br />
                La suppression d'un pays entrainera la suppression des voyages associés à ce pays.
              </p>
            </div>

            <div class="container">
              <table class="list">
                <tr>
                  <th>Code ISO</th>
                  <th>Nom</th>
                  <th>Options</th>
                </tr>
                <?php AvailableCountries(); //Affiche tous les pays disponibles?>
              </table>
            </div>
        </div>
    </div>

    <form id="del-form" method="POST" action="forms/deleteCountry.php" style="display: none;">
      <input id="del-form-input" name="del-iso" type="hidden" />
    </form>
    <form id="update-form" method="POST" action="forms/editCountry.php" style="display: none;">
    </form>

    <?php
      if(isset($_SESSION["info"]))
        showInfErr($_SESSION["info"]);
    ?>
    <?php /*Affiche le footer */ require("parts/footer.html"); ?>
  </body>
  <!-- Load scripts -->
  <script src="scripts/countries.js" defer></script>
</html>
