<?php
  // \file index.php
  // Page admin affichée par le navigateur contenant les voyages

  //Ajout des fichiers nécessaires
  require_once("../php/processing/log_admin.php");
  require_once("../php/parts/head.php");
  require_once("../php/processing/utilities.php");
  require_once("../php/processing/admin-index.php");

  //Définis les variables si celles-ci ne sont pas définis dans l'URL
  if(!isset($_GET["label"]))
    $_GET["label"] = "";

  if(!isset($_GET["country"]))
    $_GET["country"] = "ALL";

  if(!isset($_GET["duration"]))
    $_GET["duration"] = "ALL";

?>

<html>
  <!-- Génere tous les fichiers css nécessaires-->
  <?php generateHead(["index", "navbar", "header", "travel", "footer"]);?>

  <body>
    <?php /*Affiche la navbar admin */ require("parts/navbar.html"); ?>
    <?php /*Affiche le header */ require("parts/header.html"); ?>

    <div class="research-bar">
      <h2>Ajouter</h2>
      <form class="row" method="post" action="forms/newTravel.php" enctype="multipart/form-data">
        <div class="col-md-6 research-col">
          <div class="form-elements">
            <label for = "add-title">Libellé</label>
            <input type="text" id="add-title" name="add-title" maxlength="64">
          </div>
          <div class="form-elements">
            <label for = "add-description">Description</label>
            <textarea id="add-description" rows="3" name="add-description"></textarea>
          </div>
          <div class="form-elements">
            <label for="add-file">Photos</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
            <input type="file" id="add-file" name="add-file[]" accept="image/*" multiple="multiple">
          </div>
        </div>
        <div class="col-md-6 research-col">
          <div>
            <div class="form-elements">
              <label for="add-country">Pays :</label>
              <select id="add-country" name="add-country">
                <?php displayAvailableCountries(); //Affiche les pays disponibles?>
              </select>
            </div>
            <div class="form-elements">
              <label for="add-duration">Durée (en jours) : </label>
              <input type="number" id="add-duration" name="add-duration" min="1" value="1">
            </div>
          </div>
          <div class="form-elements">
            <label for = "add-price">Prix</label>
            <input type="number" id="add-price" name="add-price" min="10" value="100" step="any">
          </div>
          <div class="form-elements">
            <button type="submit" id="search-button">Ajouter</button>
          </div>
        </div>
      </form>
    </div>

    <div class="research-bar">
      <h2>Rechercher</h2>
      <form method="GET">
        <div class="research-row">
          <div class="form-inline">
            <label for="search-label">Titre :</label>
            <input list="label-datalist" name="label" placeholder="Tous" value="<?=$_GET['label']?>"/>
            <datalist id="label-datalist">
              <?php displayAvailableLabels(); //Affiche les voyages disponibles selon le titre?>
            </datalist>
          </div>
          <div class="form-inline">
            <label for="search-country">Pays :</label>
            <select name="country" id="search-country">
              <option value='ALL'>Tous</option>
              <?php displayAvailableCountries(); //Affiche les pays disponibles ?>
            </select>
          </div>
          <div class="form-inline">
            <label for="search-duration">Durée :</label>
            <select name="duration" id="search-duration">
              <option value="ALL"> Toutes </option>
              <option value="0-1"> &lt; 2 jours </option>
              <option value="2-5"> 2 à 5 jours </option>
              <option value="5-7"> 5 à 7 jours </option>
              <option value="7-14"> 1 à 2 semaines </option>
              <option value="15-29"> 3 à 4 semaines </option>
              <option value="30-60"> 1 à 2 mois </option>
              <option value="61-180"> 3 à 6 mois </option>
              <option value="181-Inf"> &gt; 6 mois </option>
            </select>
          </div>
          <div class="form-inline form-inline-right">
            <button type="submit">Rechercher</button>
          </div>
        </div>
      </form>
    </div>

    <div id="contenu">
      <div class="container">
        <div class="results-box">
          <div class="results-header">
            <h2>Votre recherche</h2>
            <ul>
              <?php displayResearchHeader($_GET["country"], $_GET["duration"], $_GET["label"]) //Affiche les paramètres de la recherche ?>
            </ul>
          </div>

          <div class="container">
            <?php displayTravels($_GET["country"], $_GET["duration"], $_GET["label"]); //Affiche les voyages en fonctions du pays et/ou la durée et/ou le titre ?>
          </div>
        </div>
      </div>
    </div>

    <?php
      //Affiche le popup d'un voyage si la variable travel est définie
      if(isset($_GET["travel"]))
        showPopup($_GET["travel"]);
      else
        echo "<script> var travelDisplayedID = null; </script>";

      if(isset($_SESSION["info"])) // Affiche une erreur, si définie
        showInfErr($_SESSION["info"]);
    ?>
    <?php /*Affiche le footer */ require("parts/footer.html"); ?>
  </body>

  <!-- Load scripts -->
  <?php jsListAvailableCountries(); ?>
  <script src="scripts/index.js" defer></script>
</html>
