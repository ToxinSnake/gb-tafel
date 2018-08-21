<?php

include "SQLiteConnection.php";

/**
* Get firstname, lastname and birthday from PNr.
*
*/

function getPerson($PNr){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }
  $sql = "SELECT Firstname, Lastname, Birthday
  FROM Person
  WHERE PNr LIKE :pnr";
  $statement = $pdo->prepare($sql);
  $statement->execute([':pnr' => $PNr]);

  return $statement;

}


?>
