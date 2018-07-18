<?php

include "SQLiteConnection.php";


function validateFirstname($firstname){
  $configs = include('config.php');
  $firstNameLength = $configs['MAX_FIRST_NAME_LENGTH'];

  if(mb_strlen($firstname) == 0){
    throw new Exception("Vorname muss mindestens ein Zeichen beinhalten!");
  }

  if(mb_strlen($firstname) > $firstNameLength ){
    throw new Exception("Vorname zu lang!");
  }
}

function validateLastname($lastname){
  $configs = include('config.php');
  $lastNameLength = $configs['MAX_LAST_NAME_LENGTH'];

  if(mb_strlen($lastname) == 0){
    throw new Exception("Nachname muss mindestens ein Zeichen beinhalten!");
  }

  if(mb_strlen($lastname) > $lastNameLength){
    throw new Exception("Nachname zu lang!");
  }
}

function validateBirthday($birthday){
  // Checks for the following format: yyyy-mm-dd
  $regex_pattern = "/[0-9]{4}-[0-9]{2}-[0-9]{2}/";

  //the === operator also checks for type compatibility
  if(preg_match($regex_pattern, $birthday) === 0){
    throw new Exception("Datum muss im Format YYYY-mm-dd vorliegen!");
  }

  // Check if the date is in the past
  $date = new DateTime($birthday);
  $now = new DateTime();
  if($date > $now){
    throw new Exception("Datum liegt in der Zukunft!");
  }
}

/**
* Adds firstname, lastname and birthday to db.
*
*/

function addToDB($firstname, $lastname, $birthday){

  //Check firstname length
  validateFirstname($firstname);

  //Check lastname length
  validateLastname($lastname);

  //check if bday is in correct format and not in the future
  validateBirthday($birthday);

  $date = new DateTime($birthday);

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
