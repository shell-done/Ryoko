<?php
// \file admin-index.php
// Contient toutes les fonctions nécessaires pour générer la page index de l'administrateur

  // Inclus les fichiers nécessaires
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");
  require("$serverRoot/php/database/travel_requests.php");

  // Affiche la liste des pays sous la forme d'options pour un <select> ou une <datalist>
  function displayAvailableCountries() {
    $db = dbConnect();
    $countries = dbGetAllCountries($db); // Récupération des pays

    // Création d'une ligne par pays avec comme value le code ISO et comme texte le nom du pays
    foreach($countries as $country) {
      echo "<option value='" . $country->getIso_code() . "'>" . $country->getName() . "</option>";
    }
  }

  // Affiche la liste des titres de voyages sous la forme d'options pour un <select> ou une <datalist>
  function displayAvailableLabels() {
    $db = dbConnect();
    $travelLabels = dbGetTravelsTitle($db); // Récupération des titres de voyages

    // Création d'une ligne par titre avec comme value le code ISO et comme texte le nom du pays
    foreach($travelLabels as $travel) {
      echo "<option value='" . $travel->getTitle() . "'>" . $travel->getTitle() . "</option>";
    }
  }

  // Créer une variable js contenant la liste des pays et de leur code ISO sous forme d'un objet
  function jsListAvailableCountries() {
    $db = dbConnect();
    $countries = dbGetAllCountries($db);

    $text = "{"; // Début de l'objet JS
    foreach($countries as $country) {
      $text .= "'" .$country->getIso_code() . "':'" . $country->getName() . "',"; // Ajout d'une ligne par pays
    }
    $text .= "}"; // Fin de l'objet JS

    echo "<script>var countryList = $text</script>"; // Ajout de la variable dans le script de la page
  }

  // Affiche les paramètres de la recherche effectuée
  // \param country Le code ISO du pays recherché
  // \param duration La période de recherche en jours sous la forme 'Jmin-Jmax'
  // \param label Le titre à rechercher dans la base
  function displayResearchHeader($country, $duration, $label) {
    $db = dbConnect();
    $countries = dbGetAllCountries($db); // Récupération des pays

    //Affichage du titre du voyage recherché
    $infoLabel = "<li>Titre : Tous</li>";
    if($label != "")
      $infoLabel = "<li>Titre : $label</li>";

    //Affichage du nom du pays et de son code ISO
    $infoCountry = "<li>Pays : Tous</li>";
    foreach($countries as $c)
      if($country == $c->getIso_code())
        $infoCountry = "<li>Pays : " . $c->getName() . " (" . $c->getIso_code() . ")</li>";

    // Liste des durées possibles
    $durations = [
      "ALL" => "Toutes",
      "0-1" => "&lt; 2 jours",
      "2-5" => "2 à 5 jours",
      "5-7" => "5 à 7 jours",
      "7-14"=> "1 à 2 semaines",
      "15-29" => "3 à 4 semaines",
      "30-60" => "1 à 2 mois",
      "61-180" => "3 à 6 mois",
      "181-Inf" => "&gt; 6 mois"
    ];

    //Affichage de la durée
    $infoDuration = "<li>Durée : Toutes</li>";
    foreach($durations as $d => $fullDuration)
      if($duration == $d)
        $infoDuration = "<li>Durée : " . $fullDuration . "</li>";

    // Affichage du titre, du pays et de la durée
    echo $infoLabel . $infoCountry . $infoDuration;
  }

  // Affiche les paramètres de la recherche effectuée
  // \param country Le code ISO du pays recherché
  // \param duration La période de recherche en jours sous la forme 'Jmin-Jmax'
  // \param label Le titre à rechercher dans la base
  function displayTravels($country, $duration, $label) {
    $db = dbConnect();

    //Initialisation de la durée min et max
    $durationMin = false;
    $durationMax = false;

    // Si on demande tous les pays, on désactive la recherche par pays
    if($country == "ALL")
      $country = false;

    // Si on demande toutes les durées, on désactive la recherche par durée
    if($duration != "ALL")
      $duration = explode("-", $duration);

    //Sinon on récupère Jmin et Jmax
    if(sizeof($duration) == 2) {
      $durationMin = $duration[0];

      if($duration[1] != "Inf") // Si la durée max est infinie, on la laisse désactivée
        $durationMax = $duration[1];
    }

    // On récupère les voyages en fonction de ces paramètres
    $travels = dbGetSelectedTravels($db, $country, $durationMin, $durationMax, false, $label);

    // On affiche tous les voyages
    foreach($travels as $travel) {
      // On utilise une miniature par défaut
      $thumbPath = "img/default_thumb.png";
      if(sizeof($travel->getImgPathList()) > 0) // Si au moins une image est disponible, on l'affiche en miniature
        $thumbPath = $travel->getImgPathList()[0];

      // Afficage de la div correspondant à un élément
      echo '
        <div id="id-travel-' . $travel->getId() . '" class="travel row" onclick="getPopup(' . $travel->getId() . ')">
          <div class="col-md-4"><img src="' . $thumbPath . '" /></div>
          <div class="col-md-8">
            <span class="travel-header">
              <h3>' . $travel->getTitle() . ' (' . $travel->getCountry() . ')</h3>
              <span class="travel-duration">Durée: ' . $travel->getDuration() .' jours</span>
            </span>
            <p class="travel-description">
              ' . $travel->getDescription() . '
            </p>
            <span class="travel-price">Prix : ' . $travel->getCost() . ' €</span>
            <span class="travel-about">Modifier/Supprimer</span>
          </div>
        </div>
      ';
    }
  }

  // Affiche le popup de détail d'un voyage
  //\param idTravel L'id du voyage à afficher
  function showPopup($idTravel) {
    $db = dbConnect();
    if(!$idTravel) {
      // On enregistre, ou non l'id du voyage actuellement affiché dans le JS (pour ne pas recharger la page en cas de click sur le même voyage)
      echo "<script> var travelDisplayedID = null; </script>";
      return;
    }
    else {
      echo "<script> var travelDisplayedID = $idTravel; </script>";
    }

    // On récupère un objet 'Travel'
    $travel = dbGetTravel($db, $idTravel);
    if(!$travel) {
      echo "<script> var travelDisplayedID = null; </script>";
      return;
    }

    // On utilise une image par défaut pour le voyage
    $img = "img/default_thumb.png";
    $thumbs = '<img src="img/default_thumb.png" />';
    if(sizeof($travel->getImgPathList()) > 0) { // Si au moins une image est disponible, on s'en sert
      $img = $travel->getImgPathList()[0];
      $thumbs = "";
    }

    foreach($travel->getImgPathList() as $t) // On récupère les miniatures
      $thumbs .= '<img src="' . $t . '" />';

    // On affiche le popup correspondant à un voyage
    echo '
      <div id="travel-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog mw-100 w-75">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close transparent" data-dismiss="modal" style="width: auto;" disabled>
                <span>&times;</span>
              </button>
              <h2 class="modal-title">' . $travel->getTitle() . '</h2>
              <button type="button" class="close" data-dismiss="modal" style="width: auto;">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="travel-modal-img-container">
                    <img id="travel-modal-img" src="' .$img . '" />
                  </div>
                  <div class="travel-modal-thumbs">
                    ' . $thumbs . '
                  </div>
                </div>
                <div class="col-md-6">
                  <h4>Description</h4>
                  <p class="travel-modal-description">
                      ' . $travel->getDescription() . '
                  </p>

                  <div class="travel-modal-info">
                    <div><h4>Pays</h4><span class="tmi tmi-country">' . $travel->getCountry() . '</span></div>
                    <div><h4>Durée</h4><span class="tmi tmi-duration">' . $travel->getDuration() . ' jours</span></div>
                    <div><h4>Prix</h4><span class="tmi tmi-cost">' . $travel->getCost(). ' €</span></div>
                  </div>

                  <div class="travel-modal-info">
                    <div></div>
                    <div>
                      <div id="travel-modal-buttons">
                        <form method="post" action="forms/editTravel.php" id="edit-travel-form">
                          <div id="tm-input-list" style="margin: 0;"></div>
                          <input id="hidden-delete-button" name="idTravel" type="hidden" value="' . $travel->getId() . '"/>
                          <button id="edit-travel" type="button" onclick="editTravel();">Modifier</button>
                        </form>
                        <form method="post" action="forms/deleteTravel.php">
                          <input id="hidden-delete-button" name="idTravel" type="hidden" value="' . $travel->getId() . '"/>
                          <button id="delete-travel" type="submit">Supprimer</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    ';
  }
?>
