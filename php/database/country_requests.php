<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/Country.php");

function dbAddCountry($db, $country){
    try{
        $request = 'INSERT INTO Country(iso_code, name) VALUES (:iso_code, :name) ';
        $statement = $db->prepare($request);
        $statement->bindParam(':iso_code', $country->getIso_code(), PDO::PARAM_STR, 3);
        $statement->bindParam(':name', $country->getName(), PDO::PARAM_STR, 64);
        $statement->execute();
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}
function dbUpdateCountry($db, $country){
    try{
        $request = 'UPDATE Country SET iso_code = :iso_code, name = :name
        WHERE iso_code = :iso_code';

        $statement = $db->prepare($request);
        $statement->bindParam(':iso_code', $country->getIso_code(), PDO::PARAM_STR, 3);
        $statement->bindParam(':name', $country->getName(), PDO::PARAM_STR, 64);
        $statement->execute();
    } catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}

function dbDeleteCountry($db, $iso_code){
    try{
        $request = 'DELETE FROM Country WHERE iso_code = :iso_code';
        $statement = $db->prepare($request);
        $statement->bindParam(':iso_code', $iso_code, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

function dbGetAllCountries($db){
    $results = array();
    try{
        $request = 'SELECT * FROM Country';
        $statement = $db->prepare($request);
        $statement->execute();

        $obj = $statement->fetchObject("Country");
        while($obj) {
          array_push($results, $obj);
          $obj = $statement->fetchObject("Country");
        }

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Country");
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $results;
}
