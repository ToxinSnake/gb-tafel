<?php

require_once "SQLiteConnection.php";
require_once "shared_methods.php";

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

  $sql = "SELECT Person.PNr, Person.Firstname, Person.Lastname, Company.CName, Department.DName, Person.Birthday FROM Person 
  INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
  INNER JOIN Company ON CId IS Company.CNr
  INNER JOIN Department ON DId IS Department.DNr;";
  return $pdo->query($sql);
}


function search($firstname, $lastname, $birthday, $company, $department){
  //Implizites % hinten anhängen
  $firstname .= "%";
  $lastname .= "%";
  $birthday .= "%";
  if(empty($company)) $company = "%";
  if(empty($department)) $department = "%";

  //error_log("Firstname:".$firstname."Lastname:".$lastname." Birthday:".$birthday." Company:".$company." Department:".$department."\n", 3, "/var/www/html/gb-tafel/log/php.log");

  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "SELECT Person.PNr, Person.Firstname, Person.Lastname, Company.CName, Department.DName, Person.Birthday 
  FROM Person 
  INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
  INNER JOIN Company ON CId IS Company.CNr
  INNER JOIN Department ON DId IS Department.DNr
  WHERE Person.Firstname LIKE :firstname 
  AND Person.Lastname LIKE :lastname 
  AND Person.Birthday LIKE :birthday 
  AND Company.CName LIKE :company 
  AND Department.DName LIKE :department;";
  $statement = $pdo->prepare($sql);
  $statement->execute([ //TRUE on success, FALSE else
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':birthday' => $birthday,
    ':company' => $company,
    ':department' => $department
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

function changeToDB($pnr, $firstname, $lastname, $birthday, $company, $department){

  //Check firstname length
  validateFirstname($firstname);

  //Check lastname length
  validateLastname($lastname);

  //check if bday is in correct format and not in the future
  validateBirthday($birthday);

  //TODO: Validierung für Company und Department

  //Connect to DB
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
  } 

  $CoDeId = getCompanyDepartmentId($company, $department);

  $sql = 'UPDATE Person
  SET Firstname = :firstname,
  Lastname = :lastname,
  Birthday = :birthday,
  Company_Department_Id = :codeid
  WHERE PNr = :pnr';

  $statement = $pdo->prepare($sql);
  $rtvalue = $statement->execute([ //TRUE on success, FALSE else
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':birthday' => $birthday,
    ':codeid' => $CoDeId,
    ':pnr' => $pnr
  ]);

  return $rtvalue;
  
}

?>
