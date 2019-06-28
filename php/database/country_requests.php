<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/Country.php");

/************************************************************************************************************/

// Ajoute un pays dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param country L'objet 'country' à insérer en base
// \return false si une erreur s'est produite, true sinon.


function dbAddCountry($db, $country) {
    try{
        $request = 'INSERT INTO Country(iso_code, name)
                    VALUES (:iso_code, :name) ';
        $statement = $db->prepare($request);

        $statement->bindValue(':iso_code', $country->getIso_code(), PDO::PARAM_STR);
        $statement->bindValue(':name', $country->getName(), PDO::PARAM_STR);

        return $statement->execute();
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return false;
}

/************************************************************************************************************/

// Modifie un pays dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param country L'objet 'country' à modifier en base
// \param prevCountryCode correspond à l'ancien code ISO pour que la base sait quel pays modifier
// \return false si une erreur s'est produite, true sinon.

function dbUpdateCountry($db, $country, $prevCountryCode) {
    try{
        $request = 'UPDATE Country
                    SET iso_code = :iso_code, name = :name
                    WHERE iso_code = :prev_iso_code';

        $statement = $db->prepare($request);
        $statement->bindValue(':iso_code', $country->getIso_code(), PDO::PARAM_STR);
        $statement->bindValue(':name', $country->getName(), PDO::PARAM_STR);
        $statement->bindParam(':prev_iso_code', $prevCountryCode);

        return $statement->execute();

    } catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}

/************************************************************************************************************/

// Supprime un pays dans la base de donnée 
// \param db Un objet PDO connecté à la base
// \param iso_code correspond au code ISO du pays à supprimer
// \return false si une erreur s'est produite, true sinon.

function dbDeleteCountry($db, $iso_code) {
    try{
        $request = 'DELETE FROM Country
                    WHERE iso_code = :iso_code';
        $statement = $db->prepare($request);
        $statement->bindParam(':iso_code', $iso_code, PDO::PARAM_INT);

        return $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

/************************************************************************************************************/

// Récupère tous les pays dans la base de donnée 
// \param db Un objet PDO connecté à la base
// \return false si une erreur s'est produite, sinon tous les pays .

function dbGetAllCountries($db) {
    $results = array();

    try{
        $request = 'SELECT name, iso_code
                    FROM Country
                    ORDER BY name';
        $statement = $db->prepare($request);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, "Country");
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $results;
}
