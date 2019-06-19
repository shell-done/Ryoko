<?php
require_once("php/classes/Travel.php");

//Fonction pour ajouter tout les voyages disponibles
function dbAddTravel($db, $travel){
    try{
        $request = 'INSERT INTO Travel(title, description, duration, cost, img_directory, country)
        VALUES (:title, :description, :duration, :cost, :img_directory, :country)';
        $statement = $db->prepare($request);
        $statement->bindParam(':title', $travel->getTitle(), PDO::PARAM_STR, 64);
        $statement->bindParam(':description', $travel->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(':duration', $travel->getDuration(), PDO::PARAM_INT);
        $statement->bindParam(':cost', $travel->getCost(), PDO::PARAM_INT);
        $statement->bindParam(':img_directory', $travel->getImgDirectory(), PDO::PARAM_STR,128);
        $statement->bindParam(':country', $travel->getCountry(), PDO::PARAM_STR);
        $statement->execute();
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}

//Fonction pour modifier tout les voyages disponibles
function dbUpdateTravel($db, $travel){
    try{
        $request = 'UPDATE Travel SET title = :title, description = :description, duration = :duration, cost = :cost, img_directory = :img_directory, country = :country
        WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':title', $travel->getTitle(), PDO::PARAM_STR, 64);
        $statement->bindParam(':description', $travel->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(':duration', $travel->getDuration(), PDO::PARAM_INT);
        $statement->bindParam(':cost', $travel->getCost(), PDO::PARAM_INT);
        $statement->bindParam(':img_directory', $travel->getImgDirectory(), PDO::PARAM_STR,128);
        $statement->bindParam(':country', $travel->getCountry(), PDO::PARAM_STR);
        $statement->bindParam(':id_travel', $travel->getId(), PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}

//Fonction pour supprimer tout les voyages disponibles
function dbDeleteTravel($db, $id_travel){
    try{
        $request = 'DELETE * FROM Travel WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $id_travel, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

//Fonction pour afficher tout les voyages disponibles
function dbGetAllTravels($db){
    $results = array();

    try{
        $request = 'SELECT *, name AS country FROM Travel, Country WHERE iso_code = country_code';
        $statement = $db->prepare($request);
        $statement->execute();

        $obj = $statement->fetchObject("Travel");
        while($obj) {
          array_push($results, $obj);
          $obj = $statement->fetchObject("Travel");
        }

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $results;
}

//Fonction pour afficher la recherche de voyages dans le barillo
function dbGetTravels($db, $country, $durationMin, $durationMax, $maxCost) {
    try{
        $request = "SELECT *, c.name AS country FROM Travel t, Country c";

        $criteria = array("c.iso_code = t.country_code");

        if($country != false) array_push($criteria, "c.name = :country");
        if($durationMin != false) array_push($criteria, "duration BETWEEN (:durationMin AND :durationMax)");
        if($maxCost != false) array_push($criteria, "cost <= :cost");

        $request .= " WHERE " . implode(" AND ", $criteria);

        $statement = $db->prepare($request);
        if($country != false) $statement->bindParam(':country', $country, PDO::PARAM_STR);
        if($durationMin != false) {
          $statement->bindParam(':durationMin', $durationMin, PDO::PARAM_INT);
          $statement->bindParam(':durationMax', $durationMax, PDO::PARAM_INT);
        }
        if($maxCost != false) $statement->bindParam(':cost', $maxCost, PDO::PARAM_INT);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return $result;
}
