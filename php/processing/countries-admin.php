<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require("$serverRoot/php/classes/Country.php");
require("$serverRoot/php/database/database.php");
require("$serverRoot/php/database/country_requests.php");

function newCountry($iso_code, $name) {
    $db = dbConnect();
    $country = new Country();
    $country->setIso_code($iso_code);
    $country->setName($name);
    $result = dbAddCountry($db, $country);
}

function AvailableCountries() {
    $db = dbConnect();
    $countries = dbGetAllCountries($db);

    foreach($countries as $country) {
      echo "  <tr id='country-" . $country->getIso_code() . "'>
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
