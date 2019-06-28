<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/Travel.php");

/************************************************************************************************************/

// Ajoute un voyage dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param travel L'objet 'travel' à insérer en base
// \return false si une erreur s'est produite, true sinon.

function dbAddTravel($db, $travel){
    try{
        $request = 'INSERT INTO Travel(title, description, duration, cost, img_directory, country_code)
                    VALUES (:title, :description, :duration, :cost, :img_directory, :country_code)';
        $statement = $db->prepare($request);
        $statement->bindValue(':title', $travel->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(':description', $travel->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(':duration', $travel->getDuration(), PDO::PARAM_INT);
        $statement->bindValue(':cost', $travel->getCost(), PDO::PARAM_INT);
        $statement->bindValue(':img_directory', $travel->getImgDirectory(), PDO::PARAM_STR);
        $statement->bindValue(':country_code', $travel->getCountry(), PDO::PARAM_STR);
        return $statement->execute();
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return false;
}

/************************************************************************************************************/

// Modifie un voyage dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param travel L'objet 'travel' à modifier en base
// \return false si une erreur s'est produite, true sinon.

function dbUpdateTravel($db, $travel) {
    try{
        $request = 'UPDATE Travel
                    SET title = :title, description = :description, duration = :duration, cost = :cost, country_code = :country
                    WHERE id_travel = :id_travel';

        $statement = $db->prepare($request);

        $statement->bindValue(':title', $travel->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(':description', $travel->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(':duration', $travel->getDuration(), PDO::PARAM_INT);
        $statement->bindValue(':cost', $travel->getCost(), PDO::PARAM_INT);
        $statement->bindValue(':country', $travel->getCountry(), PDO::PARAM_STR);
        $statement->bindValue(':id_travel', $travel->getId(), PDO::PARAM_INT);

        return $statement->execute();
    } catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return false;
}
/************************************************************************************************************/

// Supprime un voyage dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param travelID l'id du voyage à supprimer
// \return false si une erreur s'est produite, true sinon.

function dbDeleteTravel($db, $travelID) {
    try{
        $request = 'DELETE FROM Travel
                    WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $travelID, PDO::PARAM_INT);
        return $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return false;
}

/************************************************************************************************************/

//Fonction pour afficher la recherche de voyages dans le barillo

function dbGetSelectedTravels($db, $country, $durationMin, $durationMax, $maxCost, $label = "") {
    $results = false;

    try{
        $request = "SELECT id_travel, title, description, duration, cost, img_directory, c.name
                    AS country
                    FROM Travel t, Country c
                    WHERE title LIKE :label";

        $criteria = array("c.iso_code = t.country_code");

        if($country != false) array_push($criteria, "c.iso_code = :country");
        if($durationMin != false && $durationMax != false) array_push($criteria, "duration BETWEEN :durationMin AND :durationMax");
        else if($durationMin != false && $durationMax == false) array_push($criteria, "duration >= :durationMin");
        if($maxCost != false) array_push($criteria, "cost <= :cost");

        $request .= " AND " . implode(" AND ", $criteria);
        $request .= " ORDER BY t.updated DESC";

        $statement = $db->prepare($request);
        if($country != false) $statement->bindParam(':country', $country, PDO::PARAM_STR);
        if($durationMin !== false && $durationMax !== false) {
          $statement->bindParam(':durationMin', $durationMin, PDO::PARAM_INT);
          $statement->bindParam(':durationMax', $durationMax, PDO::PARAM_INT);
        } else if($durationMin != false && $durationMax == false) {
          $statement->bindParam(':durationMin', $durationMin, PDO::PARAM_INT);
        }
        if($maxCost != false) $statement->bindParam(':cost', $maxCost, PDO::PARAM_INT);
        $statement->bindValue(":label", '%' . $label . '%');

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");
        if($results == false)
          return false;

        $root = $_SERVER["DOCUMENT_ROOT"] . "/../";
        for($i=0; $i<count($results); $i++) {
          $path = $root . $results[$i]->getImgDirectory();
          $fileList = array();
          foreach(glob($path . '*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $file){
              array_push($fileList, $results[$i]->getImgDirectory() . basename($file));
          }

          $results[$i]->setImgPathList($fileList);
        }
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return $results;
}

/************************************************************************************************************/

// Récupère le voyage sélectionné dans la base de donnée 
// \param db Un objet PDO connecté à la base
// \param id_travel l'id du voyage 
// \return false si une erreur s'est produite, sinon les données du  voyage  .


function dbGetTravel($db, $id_travel) {
    $result = false;

    try{
        $request = 'SELECT id_travel, title, description, duration, cost, img_directory, c.name AS country
                    FROM Travel t, Country c
                    WHERE id_travel = :id_travel AND c.iso_code = t.country_code';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $id_travel, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchObject("Travel");

        if(!$result)
          return false;

        $root = $_SERVER["DOCUMENT_ROOT"] . "/../";
        $path = $root . $result->getImgDirectory();
        $fileList = array();
        foreach(glob($path . '*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $file){
          array_push($fileList, $result->getImgDirectory() . basename($file));
        }

        $result->setImgPathList($fileList);
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $result;
}

/************************************************************************************************************/

// Récupère le libellé des voyages dans la base de donnée 
// \param db Un objet PDO connecté à la base

// \return false si une erreur s'est produite, sinon les libellés des voyages .

function dbGetTravelsTitle($db) {
  $results = false;

  try {
    $request = 'SELECT title
                FROM Travel
                ORDER BY updated';
    $statement = $db->prepare($request);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");
    return $results;

  } catch (PDOException $exception){
      error_log('Request error: ' . $exception->getMessage());
      return false;
  }

  return false;
}
?>
