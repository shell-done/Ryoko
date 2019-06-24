<?php
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");
  require("$serverRoot/php/database/travel_requests.php");

  function displayAvailableCountries() {
    $db = dbConnect();
    $countries = dbGetAllCountries($db);

    foreach($countries as $country) {
      echo "<option value='" . $country->getIso_code() . "'>" . $country->getName() . "</option>";
    }
  }

  function displayResearchHeader($country, $duration) {
    $db = dbConnect();
    $countries = dbGetAllCountries($db);

    $infoCountry = "<li>Pays : Tous</li>";
    foreach($countries as $c)
      if($country == $c->getIso_code())
        $infoCountry = "<li>Pays : " . $c->getName() . " (" . $c->getIso_code() . ")</li>";

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

    $infoDuration = "<li>Durée : Toutes</li>";
    foreach($durations as $d => $fullDuration)
      if($duration == $d)
        $infoDuration = "<li>Durée : " . $fullDuration . "</li>";

    echo $infoCountry . $infoDuration;
  }

  function displayTravels($country, $duration) {
    $db = dbConnect();

    $durationMin = false;
    $durationMax = false;

    if(!isset($country) || $country == "ALL")
      $country = false;

    if($duration != "ALL")
      $duration = explode("-", $duration);

    if(sizeof($duration) == 2) {
      $durationMin = $duration[0];

      if($duration[1] != "Inf")
        $durationMax = $duration[1];
    }

    $travels = dbGetSelectedTravels($db, $country, $durationMin, $durationMax, false);

    for($i=0; $i<count($travels); $i++) {
      $path = "/var/www/html/" . $travels[$i]->getImgDirectory();
      $fileList = array();
      foreach(glob($path . '*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $file){
          array_push($fileList, $travels[$i]->getImgDirectory() . basename($file));
      }

      $travels[$i]->setImgPathList($fileList);
    }

    foreach($travels as $travel) {
      $thumbPath = "img/default_thumb.png";
      if(sizeof($travel->getImgPathList()) > 0)
        $thumbPath = $travel->getImgPathList()[0];

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

  function showPopup($idTravel) {
    $db = dbConnect();
    if(!$idTravel)
      return;

    $travel = dbGetTravel($db, $idTravel);

    if(!$travel)
      return;

    echo "<script>var travelData = JSON.parse(`" . json_encode($travel->toArray()) . "`)</script>";
  }
?>
