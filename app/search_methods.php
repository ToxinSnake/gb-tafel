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

function showDefault(){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "SELECT Firstname, Lastname, Birthday FROM Person LIMIT 10";
  return $pdo->query($sql);
}


function search($firstname, $lastname, $birthday){
  if($firstname == NULL){
    $firstname = "%";
  }
  if($lastname == NULL){
    $lastname = "%";
  }
  if($birthday == NULL){
    $birthday = "%";
  } 

  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "SELECT PNr, Firstname, Lastname, Birthday
  FROM Person
  WHERE Firstname LIKE :firstname
  AND Lastname LIKE :lastname
  AND Birthday LIKE :birthday
  LIMIT 10";
  $statement = $pdo->prepare($sql);
  $statement->execute([ //TRUE on success, FALSE else
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':birthday' => $birthday
  ]);

  return $statement;
}

function delete($Pnr){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "DELETE FROM Person WHERE PNr = :pnr";
  $statement = $pdo->prepare($sql);
  $statement->execute([':pnr' => $Pnr]); //TRUE on success, FALSE else

  return $statement;

}

?>
