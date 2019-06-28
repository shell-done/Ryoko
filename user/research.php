<?php
// \file research.php
// Page de recherhe de l'utilisateur

  // Inclus les fichiers nécessaires
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["research", "user-navbar", "user-research", "travel", "footer"]); //Génère le head et inclus les styles associés à la page?>

  <body>
    <?php require("parts/navbar.html"); //Affiche la barre de navigation?>

    <?php require("parts/research-banner.html"); // Affiche le fond de la barre de navigation et le champ de recherche?>

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

    <?php require("parts/info-popup.html"); // Récupère le popup d'information?>
    <?php require("parts/travel-popup.html") // Récupère le popup contenant les informations détaillées du voyage?>

    <?php require("parts/footer.html"); // Affiche le footer?>
  </body>

  <!-- Load scripts -->
  <?php require("../php/parts/user_session_token.php"); // Ajoute le token de session sur la page?>
  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/utilities.js" defer></script>
  <script src="scripts/research.js" defer></script>
</html>
