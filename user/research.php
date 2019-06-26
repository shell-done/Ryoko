<?php
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["research", "user-navbar", "user-research", "travel", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>

    <?php require("parts/research-banner.html"); ?>

    <div class="container">
      <div class="results-box">
        <div class="results-header">
          <h2>Votre recherche</h2>
          <ul>
            <li>Pays : Grèce</li>
            <li>Durée : Toutes</li>
            <li>Départ : 20/96/2019</li>
            <li>Prix max. : 300 €</li>
          </ul>
        </div>

        <div class="container travels-container">

        </div>
      </div>
    </div>

    <?php require("parts/info-popup.html"); ?>
    <?php require("parts/travel-popup.html") ?>

    <?php require("parts/footer.html"); ?>
  </body>

  <!-- Load scripts -->
  <?php require("../php/parts/user_session_token.php"); ?>
  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/utilities.js" defer></script>
  <script src="scripts/research.js" defer></script>
</html>
