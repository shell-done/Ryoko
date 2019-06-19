<?php
  require_once("php/parts/head.php");
  require_once("php/parts/navbar.php");
?>

<html>
  <?php generateHead(["index"]);?>

  <body>
    <?php navbar("NOM Prénom"); ?>

    <div class="position-relative">
      <img src="img/head.jpg" class="img-fluid"/>
      <form class="research-bar">
        <div class="form-elements">
          <label for="search-country">Pays :</label>
          <select id="search-country">
            <option name="France">France</option>
            <option name="Italie">Italie</option>
            <option name="Espagne">Espagne</option>
            <option name="Royaume-Uni">Royaume-Uni</option>
            <option name="Grèce">Grèce</option>
            <option name="Allemagne">Allemagne</option>
            <option name="Cuba">Cuba</option>
            <option name="USA">USA</option>
            <option name="Brésil">Brésil</option>
          </select>
        </div>
        <div class="form-elements">
          <label for="search-duration">Durée :</label>
          <select id="search-duration">
            <option name="all"> Toutes </option>
            <option name="<2d"> < 2 jours </option>
            <option name="2-5d"> 2 à 5 jours </option>
            <option name="1w"> 5 à 7 jours </option>
            <option name="1-2w"> 1 à 2 semaines </option>
            <option name="3-4w"> 3 à 4 semaines </option>
            <option name="1-2m"> 1 à 2 mois </option>
            <option name="3-6m"> 3 à 6 mois </option>
            <option name=">6m"> > 6 mois </option>
          </select>
        </div>
        <div class="form-elements">
          <label for="search-departure">Départ :</label>
          <input type="date" id="search-departure"/>
        </div>
        <div class="form-elements">
          <label>Prix :</label>
          <div class="slider-box">
            <input type="range" id="search-price" min="10" max="5000" value="300"/>
            <span id="search-price-value">300 €</span>
          </div>
        </div>
        <div class="form-elements">
          <button type="submit" id="search-button">Rechercher</button>
        </div>
      </form>
    </div>

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

    <?php require_once("php/parts/footer.html"); ?>
  </body>

  <!-- Load scripts -->
  <script src="scripts/index.js" defer></script>
</html>
