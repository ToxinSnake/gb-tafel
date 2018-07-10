<?php
include "SQLiteConnection.php";

/**
* Calls create() and checks returnvalue.
*/

function createDB(){
  $rtvalue = (new SQLiteConnection())->create();

  if($rtvalue == 0){ //SUCCESS
    return "Datenbank erfolgreich erstellt!";
  }
  if($rtvalue == 10){ //DB_ALREADY_EXISTS
    return "Datenbank existiert bereits!";
  }
  if($rtvalue == 101){ //CREATION_FAILED
    return "Datenbank konnte nicht erstellt werden!";
  }
}

/**
 * Calls connect() and checks the returnvalue.
 */

function testConnection(){
  $pdo = (new SQLiteConnection())->connect();

  if($pdo instanceof PDO){
    if($pdo != null){
      return "Verbindung war erfolgreich!";
    }
    else {
      return "Verbindung fehlgeschlagen!";
    }
  }

  if($pdo == 103){ //DB_DOES_NOT_EXISTS
    return "Datenbank konnte nicht gefunden werden.";
  }
}
 ?>
