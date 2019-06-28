<?php
require_once("config.php");

/************************************************************************************************************/

// Récupère la base de donnée selon les paramètres dans le fichier config.php
// \return false si une erreur s'est produite, sinon la base.

function dbConnect(){
    try{
        $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
    }
    catch (PDOException $exception){
        error_log('Connection error: '.$exception->getMessage());
        header("HTTP/1.1 503 Service unavailable");
        exit;
        return false;
    }

    return $db;
}
?>
