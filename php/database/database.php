<?php
// \file database.php
// Définit une fonction permettant de créer un PDO connecté à la BDD

//Inclus les fichiers nécessaires
require_once("config.php");

/************************************************************************************************************/

// Récupère la base de donnée selon les paramètres dans le fichier config.php
// \return un objet PDO connecté à la base
function dbConnect(){
    try{
        $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
    }
    catch (PDOException $exception){
        error_log('Connection error: '.$exception->getMessage());
        header("HTTP/1.1 503 Service unavailable");
        exit;
    }

    return $db;
}
?>
