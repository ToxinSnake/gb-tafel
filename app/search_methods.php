<?php

include "SQLiteConnection.php";

/**
* returns PDOStatement with all sets for test purposes only
*/

function showAll(){
  $pdo = (new SQLiteConnection())->connect();
  if($pdo instanceof PDO){
    $sql = 'SELECT Firstname, Lastname, Birthday FROM Person';
    return $pdo->query($sql);
  } else {
    return $pdo; //is of type int if connection fails
  }
}

?>
