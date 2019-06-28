<?php
// \file countries-admin.php
// Contient toutes les fonctions nécessaires pour générer la page countires de l'administrateur

  // Inclus les fichiers nécessaires
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Country.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/country_requests.php");

  // Prend en paramètre les informations d'un pays et l'ajout en base
  // \param iso_code Le code ISO du pays à ajouter
  // \param name Le nom du pays à ajouter
  function newCountry($iso_code, $name) {
      $db = dbConnect();
      $country = new Country();
      $country->setIso_code($iso_code);
      $country->setName($name);
      $result = dbAddCountry($db, $country);
  }

  // Génère les lignes du tableau affichant les réservations
  function AvailableCountries() {
    $db = dbConnect();
    $countries = dbGetAllCountries($db); // Récupération de tous les pays

    // Affichage d'une ligne de tableau par pays avec le code ISO, le nom du pays et les boutons 'modifier' et 'supprimer'
    foreach($countries as $country) {
      echo "<tr id='country-" . $country->getIso_code() . "'>
              <td class='iso'>" . $country->getIso_code() . "</td>
              <td class='name'>" . $country->getName() . "</td>
              <td class='options'>
                <input type='hidden' name='prev-iso' value='" . $country->getIso_code() . "' />
                <button type='button' name='edit-country' onclick=editCountry('" . $country->getIso_code() . "')> Modifier </button>
                <button type='button' name='delete-country' onclick=deleteCountry('" . $country->getIso_code() . "')> Supprimer </button>
              </td>
            </tr>";
    }
  }
?>
