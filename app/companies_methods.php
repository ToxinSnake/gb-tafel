<?php
include "SQLiteConnection.php";

function addCompanyToDb($company){

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //validate company (Check length)
    $configs = include('config.php');
    $companyLength = $configs['MAX_COMPANY_LENGTH']; 
    if(mb_strlen($company) == 0){
        throw new Exception("Firmenname muss mindestens aus einem Zeichen bestehen!");
    }
    if(mb_strlen($company) > $companyLength){
        throw new Exception("Firmenname zu lang!");
    }
    
    //check if it already exists
    $sql = 'SELECT CNr FROM Company WHERE CName IS :cname';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cname' => $company]);
    if(count($statement->fetchAll()) != 0){
        throw new Exception("Firma existiert bereits!"); 
    }


    $sql = 'INSERT INTO Company (Cname) VALUES (:cname)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([':cname' => $company]);

    return $rtvalue;

}

function companyHasDepartment($company, $department){

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

   //ID der Company finden
   $CId = getCompanyId($company);

   //ID der Abteilung holen, falls diese existiert
   $sql = 'SELECT DNr FROM Department WHERE DName IS :department';
   $statement = $pdo->prepare($sql);
   $statement->execute([':department' => $department]);
   $DId = $statement->fetch()['DNr'];

   //Wird betreten wenn eine Abteilung mit diesem Namen existiert. Es muss jetzt noch geprüft werden, ob die Abteilung auch zur selben Firma gehört
   if(!empty($DId)){ 
       //In der junction-Tabelle schauen ob die Abteilung für diese Firma bereits existiert
       $sql = 'SELECT * FROM Company_Department WHERE CId IS :cid AND DId IS :did';
       $statement = $pdo->prepare($sql);
       $statement->execute([':cid' => $CId, ':did' => $DId]);
       if(count($statement->fetchAll()) != 0){
           return true;
       } else {
           return false;
       }
   } else {
       return false;
   }
}

function addDepartmentToDb($company, $department){
    
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //validate department, 
    $configs = include('config.php');
    $departmentLength = $configs['MAX_DEPARTMENT_LENGTH']; 
    if(mb_strlen($department) == 0){
        throw new Exception("Abteilungsname muss mindestens aus einem Zeichen bestehen!");
    }
    if(mb_strlen($department) > $departmentLength){
        throw new Exception("Abteilungsname zu lang!");
    }   
    //check if it already exists
    if(companyHasDepartment($company, $department) == true){
        throw new Exception("Abteilung existiert in dieser Firma bereits!");
    }


    //ID der Company finden
    $CId = getCompanyId($company);

    //Abteilung einfügen
    $sql = 'INSERT INTO Department (Dname) VALUES (:department)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([':department' => $department]);

    //Wenn einfügen scheitert aus irgendwelchen Gründen
    if($rtvalue == false){
        return false;
    }

    //DId von neue eingefügter Abteilung holen
    $sql = 'SELECT DNr FROM Department WHERE DName IS :department';
    $statement = $pdo->prepare($sql);
    $statement->execute([':department' => $department]);
    $DId = $statement->fetch()['DNr'];

    //Einfügen von CId und DId in die junction Tabelle
    $sql = 'INSERT INTO Company_Department (CId, DId) VALUES (:cid, :did)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([
        ':cid' => $CId, 
        ':did' => $DId
    ]);
    
    return $rtvalue;

}

function deleteCompany($company){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //ID der Company finden
    $CId = getCompanyId($company);

    //Alle Department IDs finden
    $sql = 'SELECT DId FROM Company_Department WHERE CId IS :cid';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cid' => $CId]);
    $depIds = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

    //String mit Anzahl so vielen ? erstellen wie $depIdsArray groß ist
    $IdQstmark = implode(',', array_fill(0, count($depIds), '?'));

    //Alle Abteilungen der Firma löschen
    $sql = 'DELETE FROM Department WHERE DNr IN ('.$IdQstmark.')';
    $statement = $pdo->prepare($sql);
    foreach ($depIds as $k => $id){
        $statement->bindValue(($k+1), $id);
    }
    $statement->execute();
    
    //Firma löschen
    $sql = 'DELETE FROM Company WHERE CNr IS :cid';
    $statement = $pdo->prepare($sql);
    $statement->execute([':cid' => $CId]);
    
    return true;
}

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
    $sql = 'SELECT DName FROM Department WHERE DNr IN (SELECT DId FROM Company_Department WHERE CId IS (SELECT CNr FROM Company WHERE CName IS :company));';
    $statement = $pdo->prepare($sql);
    $statement->execute([':company' => $company]);

    return $statement;
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

?>