<?php

require_once "SQLiteConnection.php";
require_once "shared_methods.php";

/**
* Adds firstname, lastname and birthday to db.
*
*/

function addToDB($firstname, $lastname, $birthday, $company, $department){

  //Check firstname length
  validateFirstname($firstname);

  //Check lastname length
  validateLastname($lastname);

  //check if bday is in correct format and not in the future
  validateBirthday($birthday);

  $CoDeId = getCompanyDepartmentId($company, $department);

  $date = $birthday;

  //format date to german locale
  //$date = new DateTime($birthday);
  //$date = $date->format('d.m.Y');

  //Connect to DB
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
  }

  else{
    $sql = 'INSERT INTO Person (Firstname, Lastname, Birthday, Company_Department_Id) VALUES (:firstname, :lastname, :birthday, :codeid)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
      ':firstname' => $firstname,
      ':lastname' => $lastname,
      ':birthday' => $date,
      ':codeid' => $CoDeId
    ]);

    return $rtvalue;
  }
}
?>
