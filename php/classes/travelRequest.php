<?php
include ('classTravel.php');
include ('classCountry.php');
include ('classBooking.php');



//Fonction pour ajouter tout les voyages disponibles
function dbAddTravel($db, $titre, $description, $duree, $cout, $chemin_img, $pays){
    try{
        $request = 'INSERT INTO travel(title, description, duration, cost, img_directory, country) 
        VALUES (:title, :description, :duration, :cost, :img_directory, :country)';
        $statement = $db->prepare($request);
        $statement->bindParam(':title', $titre, PDO::PARAM_STR, 64);
        $statement->bindParam(':description', $text, PDO::PARAM_STR);
        $statement->bindParam(':duration', $duree, PDO::PARAM_INT);
        $statement->bindParam(':cost', $cout, PDO::PARAM_INT);
        $statement->bindParam(':img_directory', $chemin_img, PDO::PARAM_STR,128);
        $statement->bindParam(':country', $chemin_img, PDO::PARAM_STR);
        $statement->execute();
    }

    catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
} 

//Fonction pour modifier tout les voyages disponibles
function dbModifyTravel($db, $id_voyage, $titre, $description, $duree, $cout, $chemin_img, $pays){
    try{
        $request = 'UPDATE travel set title = :title, description = :description, duration = :duration, cost = :cost, img_directory = :img_directory, country = :country 
        WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':title', $titre, PDO::PARAM_STR, 64);
        $statement->bindParam(':description', $text, PDO::PARAM_STR );
        $statement->bindParam(':duration', $duree, PDO::PARAM_INT);
        $statement->bindParam(':cost', $cout, PDO::PARAM_INT);
        $statement->bindParam(':img_directory', $chemin_img, PDO::PARAM_STR, 128);
        $statement->bindParam(':country', $chemin_img, PDO::PARAM_STR);
        $statement->bindParam(':id_travel', $id_voyage, PDO::PARAM_INT);
        $statement->execute();
    }

    catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    return true;
}

//Fonction pour supprimer tout les voyages disponibles
function dbDeleteTravel($db, $id_voyage){
    try{
        $request = 'DELETE * FROM travel WHERE id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $id_voyage, PDO::PARAM_INT);
        $statement->execute();
    }

    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

//Fonction pour afficher tout les voyages disponibles
function dbShowAllTravels($db){ 
    try{
        $request = 'SELECT * FROM travel';
        $statement = $db->prepare($request);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}

//Fonction pour afficher la recherche de voyages
function dbShowSearchedTravels($db, $pays = '', $duree = '', $cout = ''){ 
    try{
        $request = 'SELECT * FROM travel';
        if($pays !='' && $duree != '' && $cout != ''){
            $request .= ' where country=:country AND where duration = :duration ';
            $statement = $db->prepare($request);
            $statement->bindParam(':country', $pays, PDO::PARAM_STR);
            $statement->bindParam(':duration', $duree, PDO::PARAM_INT);
            $statement->bindParam(':cost', $cout, PDO::PARAM_INT);
        }
        if($pays !='' && $duree = ''){
            $request .= ' where country=:country AND where duration = :duration ';
            $statement = $db->prepare($request);
            $statement->bindParam(':country', $pays, PDO::PARAM_STR);
            $statement->bindParam(':duration', $duree, PDO::PARAM_INT);
        }
        else if($pays !=''){
            $request .= ' where country = :country ';
            $statement = $db->prepare($request);
            $statement->bindParam(':country', $pays, PDO::PARAM_STR);
        }
        else($duree !=''){
            $request .= ' where duration = :duration ';
            $statement = $db->prepare($request);
            $statement->bindParam(':duration', $duree, PDO::PARAM_INT);
        }
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}    



//Partie Utilisateur
function dbUserTravels($db, $email, $id_voyage, $date_depart, $date_retour, $cout_total, $statut_validation){
    try{
        $request = 'SELECT * FROM booking WHERE user_email = :user_email';
        $statement = $db->prepare($request);
        $statement->bindParam(':user_email', $email, PDO::PARAM_STR, 128);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}
}