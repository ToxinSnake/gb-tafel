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

  $sql = "SELECT PNr, Firstname, Lastname, Birthday FROM Person ORDER BY PNr DESC LIMIT 10";
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

function changeToDB($pnr, $firstname, $lastname, $birthday){

  //Check firstname length
  validateFirstname($firstname);

  //Check lastname length
  validateLastname($lastname);

  //check if bday is in correct format and not in the future
  validateBirthday($birthday);

  $date = $birthday;

  //Connect to DB
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
  }

  else{
    $sql = 'UPDATE Person
    SET Firstname = :firstname,
    Lastname = :lastname,
    Birthday = :birthday
    WHERE PNr = :pnr';

    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
      ':firstname' => $firstname,
      ':lastname' => $lastname,
      ':birthday' => $date,
      ':pnr' => $pnr
    ]);

    return $rtvalue;
  }
}

?>
