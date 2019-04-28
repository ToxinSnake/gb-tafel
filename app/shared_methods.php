<?php
require_once "SQLiteConnection.php";

function getCompanies(){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
    $sql = 'SELECT Cname FROM Company';
    return $pdo->query($sql);
}

function getDepartments($company){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //Gibt alle Abteilungen der Firma zurück
    $sql = 'SELECT DName 
    FROM Department 
    WHERE DNr 
    IN (SELECT DId FROM Company_Department WHERE CId IS (SELECT CNr FROM Company WHERE CName IS :company));';
    $statement = $pdo->prepare($sql);
    $statement->execute([':company' => $company]);

    return $statement;
}

function getDepartmentsRowCount($company){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zur DB gescheitert!");
  }

  //Gibt alle Abteilungen der Firma zurück
  $sql = 'SELECT COUNT(*) 
  FROM (SELECT DName 
        FROM Department 
        WHERE DNr IN (SELECT DId FROM Company_Department WHERE CId IS (SELECT CNr FROM Company WHERE CName IS :company)));';
  $statement = $pdo->prepare($sql);
  $statement->execute([':company' => $company]);

  return $statement->fetchColumn()[0];
}

/*
Hilfsmethode, gibt zu einer Company die passende ID zurück.
*/
function getCompanyId($company){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'SELECT CNr FROM Company WHERE CName IS :company';
    $statement = $pdo->prepare($sql);
    $statement->execute([':company' => $company]);
    return $statement->fetch()['CNr'];
}

function companyHasDepartment($company, $department){

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

   //ID der Company finden
   $CId = getCompanyId($company);

    //In der junction-Tabelle schauen ob die Abteilung für diese Firma bereits existiert
    $sql = 'SELECT * FROM Company_Department WHERE CId IS :cid AND DId IS (SELECT DNr FROM Department WHERE DName IS :department)';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cid' => $CId, ':department' => $department]);
    if(count($statement->fetchAll()) != 0){
        return true;
    } else {
        return false;
    }
}

/*
Hilfsmethode, gibt zu einem Department die passende ID zurück, sofern diese in der gewählten Firma existiert.
*/
function getDepartmentId($company, $department){

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
  
   //ID der Company finden
   $CId = getCompanyId($company);
  
    //In der junction-Tabelle schauen ob die Abteilung zu der Firma gehört.
    $sql = 'SELECT * FROM Company_Department WHERE CId IS :cid AND DId IS (SELECT DNr FROM Department WHERE DName IS :department)';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cid' => $CId, ':department' => $department]);
    $DId = $statement->fetch()['DId'];
    if(!empty($DId)){
      return $DId;
    } else {
      return false;
    }
  }
  

  /*
  Gibt die CoDeId für ein Firmen-Abteilungs Tuple zurück. Diese ist wichtig für das Eintragen neuer Personen.
  */
  function getCompanyDepartmentId($company, $department) {
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zur DB gescheitert!");
    }
  
    $CId = getCompanyId($company);
    $DId = getDepartmentId($company, $department);
  
    if($DId === false){
      throw new Exception("Abteilung existiert in dieser Firma nicht!");
    }
  
    $sql = 'SELECT CoDeId FROM Company_Department WHERE CId IS :cid AND DId IS :did';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cid' => $CId, ':did' => $DId]);
    return $statement->fetch()['CoDeId'];
  }

function findCompanyForPerson($Pnr){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }
  
  $sql = "SELECT Company.CName 
  FROM Person 
  INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
  INNER JOIN Company ON CId IS Company.CNr
  INNER JOIN Department ON DId IS Department.DNr
  WHERE Person.PNr IS :pnr;";
  $statement = $pdo->prepare($sql);
  $statement->execute([':pnr' => $Pnr]);
  
  return $statement->fetchAll()[0][0];
}

function findDepartmentForPerson($Pnr){
  $pdo = (new SQLiteConnection())->connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "SELECT Department.DName 
  FROM Person 
  INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
  INNER JOIN Company ON CId IS Company.CNr
  INNER JOIN Department ON DId IS Department.DNr
  WHERE Person.PNr IS :pnr;";
  $statement = $pdo->prepare($sql);
  $statement->execute([':pnr' => $Pnr]);
  
  return $statement->fetchAll()[0][0];
}

function getRowCount($query){
  $pdo = (new SQLiteConnection())->connect();
  if (! ($pdo instanceof PDO)) {
      throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }
  return count($pdo->query($query)->fetchAll());
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
?>