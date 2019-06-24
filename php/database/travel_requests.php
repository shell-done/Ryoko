<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/Travel.php");

//Fonction pour ajouter tout les voyages disponibles
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

    return true;
}

//Fonction pour modifier tout les voyages disponibles
function dbUpdateTravel($db, $travel){
    try{
        $request = 'UPDATE Travel, Country c SET title = :title, description = :description, duration = :duration, cost = :cost, img_directory = :img_directory, country_code = c.iso_code
        WHERE id_travel = :id_travel AND c.name = :country';

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
function dbDeleteTravel($db, $travel){
    try{
        $request = 'DELETE FROM Travel WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $travel->getId(), PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

//Fonction pour afficher la recherche de voyages dans le barillo
function dbGetSelectedTravels($db, $country, $durationMin, $durationMax, $maxCost) {
    $results = false;

    try{
        $request = "SELECT id_travel, title, description, duration, cost, img_directory, c.name AS country FROM Travel t, Country c";

        $criteria = array("c.iso_code = t.country_code");

        if($country != false) array_push($criteria, "c.iso_code = :country");
        if($durationMin != false && $durationMax != false) array_push($criteria, "duration BETWEEN :durationMin AND :durationMax");
        else if($durationMin != false) array_push($criteria, "duration >= :durationMin");
        if($maxCost != false) array_push($criteria, "cost <= :cost");

        $request .= " WHERE " . implode(" AND ", $criteria);

        $statement = $db->prepare($request);
        if($country != false) $statement->bindParam(':country', $country, PDO::PARAM_STR);
        if($durationMin !== false) {
          $statement->bindParam(':durationMin', $durationMin, PDO::PARAM_INT);
          $statement->bindParam(':durationMax', $durationMax, PDO::PARAM_INT);
        }
        if($maxCost != false) $statement->bindParam(':cost', $maxCost, PDO::PARAM_INT);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");

        for($i=0; $i<count($results); $i++) {
          $path = "/var/www/html/" . $results[$i]->getImgDirectory();
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

//Afiicher le voyage sélectionner
function dbGetTravel($db, $id_travel){
    $result = false;

    try{
        $request = 'SELECT id_travel, title, description, duration, cost, img_directory, c.name AS country FROM Travel t, Country c WHERE id_travel = :id_travel AND c.iso_code = t.country_code';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $id_travel, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchObject("Travel");

        $path = "/var/www/html/" . $result->getImgDirectory();
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
?>
