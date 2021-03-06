<?php
// \file index.php
// Page principale du site affichée à l'utilisateur lors de la connexion

  // Inclus les fichiers nécessaires
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["index", "user-navbar", "user-research", "footer"]); //Génère le head et inclus les styles associés à la page?>

  <body>
    <?php require("parts/navbar.html"); //Affiche la barre de navigation ?>

    <?php require("parts/research-banner.html"); // Affiche le fond de la barre de navigation et le champ de recherche?>

    <div class="container">
      <table class="trending-travel">
        <tr>
          <td><img src="img/trending.png" class="trending-img"/></td>
          <td>
            <div class="trending-details">
              <h3>Découvrez la Grèce</h3>
              <p>
                Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum erunt homines Roma,
                ut augeretur sublimibus incrementis, foedere pacis aeternae. Virtus convenit atque Fortuna plerumque
                dissidentes, quarum si altera defuisset, ad perfectam non venerat summitatem.
                Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum erunt homines Roma,
                ut augeretur sublimibus incrementis, foedere pacis aeternae.
              </p>
              <span class="trending-link">En savoir plus...</span>
            </div>
          </td>
        </tr>
      </table>

      <h2>Nos meilleurs destinations</h2>
      <div class="best-dest-list">
        <div class="best-dest">
          <img src="img/thumbs/turquie.jpg" />
          <h4>Istanbul</h4>
          <span>2 mois</span>
        </div>

        <div class="best-dest">
          <img src="img/thumbs/france.jpg" />
          <h4>Paris</h4>
          <span>3 jours</span>
        </div>

        <div class="best-dest">
          <img src="img/thumbs/maldives.jpg" />
          <h4>Maldives</h4>
          <span>2 semaines</span>
        </div>
      </div>
    </div>

    <?php require("parts/info-popup.html"); // Récupère le popup d'information ?>
    <?php require_once("parts/footer.html"); // Affiche le footer?>
  </body>

  <!-- Load scripts -->
  <?php require("../php/parts/user_session_token.php"); // Ajoute le token de session sur la page?>
  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/utilities.js" defer></script>
  <script src="scripts/index.js" defer></script>
</html>
