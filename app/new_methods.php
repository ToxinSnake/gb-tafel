<?php

include "SQLiteConnection.php";

/**
* Adds firstname, lastname and birthday to db.
* Checks for length of names and throws an Exception if they exceed the limit.
*/

function addToDB($firstname, $lastname, $birthday){
  $configs = include('config.php');

  $firstNameLength = intval($configs['MAX_FIRST_NAME_LENGTH']);
  $lastNameLength = intval($configs['MAX_LAST_NAME_LENGTH']);

  //Check firstname length
  if(mb_strlen($firstname) > $firstNameLength){
    throw new Exception("Vorname zu lang!");
  }

  //Check lastname length
  if(mb_strlen($lastname) > $lastNameLength){
    throw new Exception("Nachname zu lang!");
  }

  //check wether bday is in the future
  $date = new DateTime($birthday);
  $now = new DateTime();
  if($date > $now){
    throw new Exception("Datum liegt in der Zukunft!");
  }

  //format date to german locale
  $date = $date->format('d.m.Y');

  //Connect to DB
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
  }

  else{
    $sql = 'INSERT INTO Person (Firstname, Lastname, Birthday) VALUES (:firstname, :lastname, :birthday)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
      ':firstname' => $firstname,
      ':lastname' => $lastname,
      ':birthday' => $date
    ]);

    return $rtvalue;
  }
}
?>
