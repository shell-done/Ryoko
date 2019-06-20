<?php
require_once("config.php");

function dbConnect(){
    try{
        $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
    }
    catch (PDOException $exception){
        header("HTTP/1.1 503 Service unavailable");
        //error_log('Connection error: '.$exception->getMessage());
        return false;
    }
    
    return $db;
}
?>