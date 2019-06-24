<?php require_once("../php/parts/head.php");?>


<html>
  <?php generateHead(["index", "navbar", "header", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>
    <?php require("parts/header.html"); ?>

    <div class="position-relative">
      <form class="add-travel-bar">
        <h2>Ajouter</h2>
        <div id="box1">
          <div class="form-elements">
            <label for = "add-title">Libellé</label>
            <input type="text" id="add-title" maxlength="64">
          </div>
          <div class="form-elements">
            <label for = "add-description">Description</label>
            <textarea id="add-description"></textarea>
            </div>
        </div>
        <div id="box2">
          <div class="form-inline">
            <label for="Add-country">Pays :</label>
            <select id="Add-country">
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
          <div class="form-inline">
            <label for="add-duration">Durée(en jours) :</label>
            <input type="number" id="add-duration" min="1" max = "183">
          </div>
          <div class="form-elements">
            <button type="submit" id="search-button">Ajouter</button>
          </div>
        </div>
      </form>
    </div>

    <div class="position-relative">
      <form class="research-bar">
        <h2>Rechercher</h2>
        <div id="box1">
          <div class="form-inline">
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
        </div>
        <div id="box2">
          <div class="form-inline">
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
        </div>
        <div id="box3">
          <div class="form-elements">
            <button type="submit" id="search-button">Rechercher</button>
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
              <li>Pays : Grèce</li>
              <li>Durée : Toutes</li>
            </ul>
          </div>

          <div class="container">
            <div id="id-travel-1" class="travel row">
              <div class="col-md-4"><img src="img/default_thumb.png" /></div>
              <div class="col-md-8">
                <span class="travel-header">
                  <h3>Cancún (Mexique)</h3>
                  <span class="travel-duration">Durée: 5 jours</span>
                </span>
                <p class="travel-description">
                  Tempore quo primis auspiciis in mundanum fulgorem surgeret
                  victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                  foedere pacis aeternae .
                </p>
                <span class="travel-price">Prix : 500 €</span>
                <span class="travel-about" data-toggle="modal" data-target="#travel-modal">Modifier/Supprimer</span>
              </div>
            </div>

            <div id="id-travel-2" class="travel row">
              <div class="col-md-4"><img src="img/default_thumb.png" /></div>
              <div class="col-md-8">
                <span class="travel-header">
                  <h3>Week-end à Paris (France)</h3>
                  <span class="travel-duration">Durée: 2 jours</span>
                </span>
                <p class="travel-description">
                  Tempore quo primis auspiciis in mundanum fulgorem surgeret
                  victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                  foedere pacis aeternae .
                </p>
                <span class="travel-price">Prix : 500 €</span>
                <span class="travel-about" data-toggle="modal" data-target="#travel-modal">Modifier/Supprimer</span>
              </div>
            </div>

            <div id="id-travel-3" class="travel row">
              <div class="col-md-4"><img src="img/default_thumb.png" /></div>
              <div class="col-md-8">
                <span class="travel-header">
                  <h3>Istanbul (Turquie)</h3>
                  <span class="travel-duration">Durée: 2 semaines</span>
                </span>
                <p class="travel-description">
                  Tempore quo primis auspiciis in mundanum fulgorem surgeret
                  victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                  foedere pacis aeternae .
                </p>
                <span class="travel-price">Prix : 500 €</span>
                <span class="travel-about" data-toggle="modal" data-target="#travel-modal">Modifier/Supprimer</span>
              </div>
            </div>
          </div>
      </div>
    </div>

    <?php require("parts/travel-popup.html") ?>
    <?php require("parts/footer.html"); ?>
  </body>

  <!-- Load scripts -->
  <script src="scripts/research.js" defer></script>
</html>
